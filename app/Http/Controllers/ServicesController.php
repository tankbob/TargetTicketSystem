<?php

namespace TargetInk\Http\Controllers;

use Illuminate\Http\Request;

use TargetInk\Http\Requests;
use TargetInk\Http\Controllers\Controller;

use TargetInk\User;
use TargetInk\Service;
use Storage;

class ServicesController extends Controller
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
        return view('dashboard.services.serviceList', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.services.serviceEdit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $service = new Service;
        $service->fill($request->all());

        if($request->hasFile('icon') && $request->file('icon')->isValid()) {
            $file = $request->file('icon');
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

            Storage::disk('s3')->put($filename, file_get_contents($request->file('icon')->getRealPath()));

            $service->icon = config('app.asset_url') . $filename;
        }

        if($request->hasFile('icon_rollover') && $request->file('icon_rollover')->isValid()) {
            $file = $request->file('icon_rollover');
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

            Storage::disk('s3')->put($filename, file_get_contents($request->file('icon_rollover')->getRealPath()));

            $service->icon_rollover = config('app.asset_url') . $filename;
        }

        $service->save();
        return redirect('/?services&client_id=' . $request->get('client_id') . '#services-div');
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
            $client = User::with('services')->find($id);
        }
        return view('dashboard.services.serviceShow', compact('client'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = Service::find($id);
        $service->delete();
        return json_encode([
            'success'   => 'The Service has been deleted.',
            'method'    => 'delete',
            'id'        => $id,
        ]);
    }
}
