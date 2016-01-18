<?php

namespace TargetInk\Http\Controllers;

use Illuminate\Http\Request;
use TargetInk\Http\Requests;
use TargetInk\Http\Controllers\Controller;

use TargetInk\Http\Requests\AdvertCreateRequest;

use TargetInk\User;
use TargetInk\Advert;
use Storage;

class AdvertController extends Controller
{
    // Should be admin
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $advertList = view('dashboard.adverts.advertList');
        if(request()->ajax()) {
            return $advertList;
        } else {
            return view('dashboard', compact('advertList'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $advertForm = view('dashboard.adverts.advertEdit');
        if(request()->ajax()) {
            return $advertForm;
        } else {
            $advertList = view('dashboard.adverts.advertList');
            return view('dashboard', compact('advertList', 'advertForm'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdvertCreateRequest $request)
    {
        $advert = new Advert;
        $advert->fill($request->all());

        if($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

            $counter = 2;
            $fcache = $filename;
            while(Storage::disk('s3')->has($filename . '.' . $extension)) {
                $filename = $fcache . '_' . $counter;
                $counter++;
            }

            $filename = $filename . '.' . $extension;

            // Sanitize
            $filename = mb_ereg_replace("([^\w\s\d\-_~,;:\[\]\(\).])", '', $filename);
            $filename = mb_ereg_replace("([\.]{2,})", '', $filename);

            Storage::disk('s3')->put($filename, file_get_contents($request->file('image')->getRealPath()));

            $advert->image = $filename;
        }

        $advert->save();

        return redirect()->back()->with('success', 'The Advert has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = null;
        if(auth()->user()->admin && $id) {
            $client = User::with('adverts')->find($id);
        }

        $advertTable = view('dashboard.adverts.advertShow', compact('client'));
        if(request()->ajax()) {
            return $advertTable;
        } else {
            // Always show the form for direct hits
            $advertForm = view('dashboard.adverts.advertEdit');
            $advertList = view('dashboard.adverts.advertList');
            return view('dashboard', compact('advertList', 'advertTable', 'advertForm'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $advert = Advert::find($id);
        $advert->delete();
        return json_encode([
            'success'   => 'The Advert has been deleted.',
            'method'    => 'delete',
            'id'        => $advert->id,
        ]);
    }
}
