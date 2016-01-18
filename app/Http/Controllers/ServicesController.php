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
        $serviceList = view('dashboard.services.serviceList');
        if(request()->ajax()) {
            return $serviceList;
        } else {
            return view('dashboard', compact('serviceList'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $serviceForm = view('dashboard.services.serviceEdit');
        if(request()->ajax()) {
            return $serviceForm;
        } else {
            $serviceList = view('dashboard.services.serviceList');
            return view('dashboard', compact('serviceList', 'serviceForm'));
        }
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

            $service->icon = $filename;
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

            $service->icon_rollover = $filename;
        }

        $service->save();
        return redirect()->back()->with('success', 'The Service has been added');
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

        $serviceTable = view('dashboard.services.serviceShow', compact('client'));
        if(request()->ajax()) {
            return $serviceTable;
        } else {
            // Always show the form for direct hits
            $serviceForm = view('dashboard.services.serviceEdit');
            $serviceList = view('dashboard.services.serviceList');
            return view('dashboard', compact('serviceList', 'serviceTable', 'serviceForm'));
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
        $service = Service::find($id);
        $service->delete();
        return json_encode([
            'success'   => 'The Service has been deleted.',
            'method'    => 'delete',
            'id'        => $id,
        ]);
    }
}
