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
        if($type == 'seo') {
            $files = $client->seoFiles;
        }elseif($type == 'info') {
            $files = $client->infoFiles;
        } else {
            abort(404);
        }
        return view('documents', compact('files', 'type'));
    }

}
