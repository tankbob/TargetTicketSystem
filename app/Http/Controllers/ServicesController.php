<?php

namespace TargetInk\Http\Controllers;

use Illuminate\Http\Request;

use TargetInk\Http\Requests;
use TargetInk\Http\Controllers\Controller;

use TargetInk\User;
use TargetInk\Service;

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
            $image = \Image::make($file);
            $image->fit(146, 146);
            $destinationPath = public_path() . '/files/services';
            $counter = 1;
            $filename = $file->getClientOriginalName();
            while(file_exists($destinationPath. '/' . $filename)) {
                $filename = $counter. '-' . $file->getClientOriginalName();
                $counter++;
            }
            $image->save($destinationPath. '/' . $filename);
            $service->icon = $filename;
        }

        if($request->hasFile('icon_rollover') && $request->file('icon_rollover')->isValid()) {
            $file = $request->file('icon_rollover');
            $image = \Image::make($file);
            $image->fit(146, 146);
            $destinationPath = public_path() . '/files/services';
            $counter = 1;
            $filename = $file->getClientOriginalName();
            while(file_exists($destinationPath. '/' . $filename)) {
                $filename = $counter. '-' . $file->getClientOriginalName();
                $counter++;
            }
            $image->save($destinationPath. '/' . $filename);
            $service->icon_rollover = $filename;
        }
        $service->save();
        return redirect('/?service=' . $request->get('client_id') . '#services-div');
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
        $service = Service::find($id);
        $service->delete();
        return json_encode([
            'success'   =>  'The Service has been deleted.',
            'method'    =>  'delete',
            'id'        =>  $id
        ]);
    }
}
