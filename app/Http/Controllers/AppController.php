<?php

namespace TargetInk\Http\Controllers;

use Illuminate\Http\Request;
use TargetInk\Http\Requests;
use TargetInk\Http\Controllers\Controller;
use TargetInk\User;
use JsValidator;

class AppController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $clients = null;
        if(auth()->user()->admin) {
            $clients = User::where('admin', 0)->orderBy('company')->get();
        }
        return view('dashboard', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('dashboard.advertEdit');
    }

    public function showMaintenance(Request $request) {
        $clients = User::where('admin', 0)->orderBy('company')->get();

        $maintenanceList = view('dashboard.tickets.tickets', compact('clients'));
        if($request->ajax()) {
            return $maintenanceList;
        } else {
            return view('dashboard', compact('maintenanceList'));
        }
    }

    public function js() {
        $adminValidators = [
            'TargetInk\Http\Requests\ClientCreateRequest' => '#new-client-form',
            'TargetInk\Http\Requests\ClientUpdateRequest' => '#update-client-form',

            'TargetInk\Http\Requests\AdvertCreateRequest' => '#new-advert-form',
            'TargetInk\Http\Requests\AdvertUpdateRequest' => '#update-advert-form',

            'TargetInk\Http\Requests\ServiceCreateRequest' => '#new-service-form',
            'TargetInk\Http\Requests\ServiceUpdateRequest' => '#update-service-form',

            'TargetInk\Http\Requests\DocumentSeoCreateRequest' => '#new-seo-form',
            'TargetInk\Http\Requests\DocumentSeoUpdateRequest' => '#update-seo-form',

            'TargetInk\Http\Requests\DocumentInfoCreateRequest' => '#new-info-form',
            'TargetInk\Http\Requests\DocumentInfoUpdateRequest' => '#update-info-form',
        ];

        $userValidators = [
        ];
        
        if(auth()->user()->admin) {
            $v = $adminValidators;
        } else {
            $v = $userValidators;
        }

        $content = '';
        foreach($v as $requestClass => $formSelector) {
            $content .= JsValidator::formRequest($requestClass, $formSelector);
        }

        return response($content)->header('Content-Type', 'text/javascript');
    }
}
