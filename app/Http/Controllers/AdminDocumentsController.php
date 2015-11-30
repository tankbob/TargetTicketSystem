<?php

namespace TargetInk\Http\Controllers;

use Illuminate\Http\Request;

use TargetInk\Http\Requests;
use TargetInk\Http\Controllers\Controller;

use TargetInk\User;
use TargetInk\File;

class AdminDocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type)
    {
        $clients = null;
        if(auth()->user()->admin){
            $clients = User::where('admin', 0)->orderBy('company')->lists('web', 'id')->toArray();
        }
        return View('dashboard.documents.documentList', compact('clients', 'type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type)
    {
        return View('dashboard.documents.documentEdit', compact('type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($type, Request $request)
    {
        $file = new File;
        $file->fill($request->all());
        if($type == 'seo'){
            $file->type = 0;
        }else{
            $file->type = 1;
        }
        if(\Request::hasFile('file') && \Request::file('file')->isValid()){
            $tempfile = \Request::file('file');        
            $destinationPath = public_path().'/files/documents';

            $counter = 1;
            $filename = $tempfile->getClientOriginalName();
            while(file_exists($destinationPath.'/'.$filename)){
                $filename = $counter.'-'.$tempfile->getClientOriginalName();
                $counter++;
            }
            $tempfile->move($destinationPath, $filename);
            $file->filepath = $filename;
        }
        $file->save();
        return \Redirect::to('/?'.$type.'='.$request->get('client_id').'#'.$type.'-div');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($type, $id)
    {
        $client = null;
        if(auth()->user()->admin && $id){
            $client = User::find($id);
        }
        return View('dashboard.documents.documentShow', compact('client', 'type'));
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
    public function destroy($type, $id)
    {
        $file = File::find($id);
        $file->delete();
        return json_encode([
            'success'   =>  'The '.$type.' document has been deleted.',
            'method'    =>  'delete',
            'id'        =>  $id
        ]);
    }
}
