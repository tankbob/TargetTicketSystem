<?php

namespace TargetInk\Http\Controllers;

use Illuminate\Http\Request;
use TargetInk\Http\Requests;
use TargetInk\Http\Controllers\Controller;

use TargetInk\User;
use TargetInk\Libraries\Slug;

class ClientsController extends Controller
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
        $clients = null;
        if(auth()->user()->admin) {
            $clients = User::where('admin', 0)->orderBy('company')->get();
        }
        return view('dashboard.clients.clientList', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.clients.clientEdit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $client = new User;
        $client->fill($request->except(['password']));
        $client->password = bcrypt($request->get('password'));
        $client->company_slug = Slug::make($request->get('company'), 'users', 'company_slug');
        $client->save();
        return json_encode([
            'success'   =>  'The Client has been created.',
            'method'    =>  'create',
            'id'        =>  $client->id,
            'email'     =>  $client->email,
            'name'      =>  $client->name
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = User::where('admin', 0)->find($id);
        return view('dashboard.clients.clientEdit', compact('client'));
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
        $client = User::find($id);
        $client->fill($request->except(['password']));
        if($request->has('password')) {
           $client->password = bcrypt($request->get('password'));
        }
        $client->save();
        return json_encode([
            'success'   =>  'The Client has been updated.',
            'method'    =>  'update',
            'id'        =>  $client->id,
            'email'     =>  $client->email,
            'name'      =>  $client->name
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = User::find($id);
        $client->delete();
        return json_encode([
            'success'   => 'The Client has been deleted.',
            'method'    => 'delete',
            'id'        => $client->id,
        ]);
    }
}
