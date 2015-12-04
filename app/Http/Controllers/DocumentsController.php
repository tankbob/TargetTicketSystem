<?php

namespace TargetInk\Http\Controllers;

use Illuminate\Http\Request;
use TargetInk\User;
use TargetInk\Http\Requests;
use TargetInk\Http\Controllers\Controller;

class DocumentsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('ownCompany');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($company_slug, $type)
    {
        $client = User::where('company_slug', '=', $company_slug)->first();
        if($type == 'seo'){
            $files = $client->seoFiles;
        }elseif($type == 'info'){
            $files = $client->infoFiles;
        }else{
            abort(404);
        }
        return view('documents', compact('files', 'type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($company_slug, $type)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($company_slug, $type, Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($company_slug, $type, $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($company_slug, $type, $id)
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
    public function update($company_slug, $type, Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($company_slug, $type, $id)
    {
        //
    }
}
