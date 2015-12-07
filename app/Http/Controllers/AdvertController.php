<?php

namespace TargetInk\Http\Controllers;

use Illuminate\Http\Request;
use TargetInk\Http\Requests;
use TargetInk\Http\Controllers\Controller;

use TargetInk\User;
use TargetInk\Advert;

class AdvertController extends Controller
{
    //should be admin
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
        $clients = null;
        if(auth()->user()->admin) {
            $clients = User::where('admin', 0)->orderBy('company')->lists('web', 'id')->toArray();
        }
        return view('dashboard.adverts.advertList', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.adverts.advertEdit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $advert = new Advert;
        $advert->fill($request->all());
        if($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');
            $image = \Image::make($file);
            $image->resize(null, 400, function ($constraint) {
                $constraint->aspectRatio();
            });
            $destinationPath = public_path().'/files/banners';
            $counter = 1;
            $filename = $file->getClientOriginalName();
            while(file_exists($destinationPath.'/'.$filename)) {
                $filename = $counter.'-'.$file->getClientOriginalName();
                $counter++;
            }
            $image->save($destinationPath.'/'.$filename);
            $advert->image = $filename;
        }
        $advert->save();
        return redirect('/?advert='.$request->get('client_id').'#advertDiv');
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
        return view('dashboard.adverts.advertShow', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
            'success'   =>  'The Advert has been deleted.',
            'method'    =>  'delete',
            'id'        =>  $advert->id
        ]);
    }
}
