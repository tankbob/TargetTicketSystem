<?php

namespace TargetInk\Http\Controllers;

use Illuminate\Http\Request;
use TargetInk\Http\Requests;
use TargetInk\Http\Controllers\Controller;

use TargetInk\User;

class UserController extends Controller
{

    public function getInfo(Request $request) {
        $client_id = $request->input('client_id');
        $client = User::where('admin', 0)->find($client_id)->toArray();
        echo json_encode($client);
    }

}
