<?php

namespace TargetInk\Http\Controllers;

use Illuminate\Http\Request;
use TargetInk\Http\Requests;
use TargetInk\Http\Requests\ClientCreateRequest;
use TargetInk\Http\Controllers\Controller;

use TargetInk\User;
use TargetInk\Libraries\Slug;
use Mail;
use Storage;

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
    public function store(ClientCreateRequest $request)
    {
        $client = new User;
        $client->fill($request->except(['password']));
        $client->password = bcrypt($request->get('password'));
        $client->company_slug = Slug::make($request->get('company'), 'users', 'company_slug');
        $client->instant = sha1($request->get('name') . $request->get('email') . $request->get('company'));

        if($request->hasFile('company_logo') && $request->file('company_logo')->isValid()) {
            $file = $request->file('company_logo');
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

            Storage::disk('s3')->put($filename, file_get_contents($request->file('company_logo')->getRealPath()));

            $file->filepath = config('app.asset_url') . $filename;
            $client->company_logo = $filename;
        }

        // Save the client
        $client->save();
        $client->pre_pass = $request->get('password');

        // Send an email
        foreach([$client->email => $client->instant, config('app.email_to') => false] as $recipientEmail => $recipientInstantKey) {
            Mail::send('emails.newUser', ['instant' => $recipientInstantKey, 'user' => $client], function ($message) use ($client, $recipientEmail) {
                $message->to($recipientEmail);
                $message->subject('Target Ink Ltd Maintenance Account setup for ' . $client->email);
            });
        }

        return redirect()->back()->with('success', 'The client has been created')->with('client', $client);
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

        // Check the email
        if($client->email != $request->get('email')) {
            // We are changing the email
            $emailCheck = User::where('email', $request->get('email'))->get();
            if($emailCheck) {
                // Someone else has this email already
                return json_encode([
                    'error'     => 'That email is already taken.',
                    'success'   => false,
                    'method'    => 'update',
                    'id'        => $client->id,
                    'email'     => $client->email,
                    'name'      => $client->name,
                ]);
            }
        }

        $client->fill($request->except(['password']));
        if($request->has('password')) {
           $client->password = bcrypt($request->get('password'));
        }
        $client->save();
        return json_encode([
            'success'   => 'The Client has been updated.',
            'method'    => 'update',
            'id'        => $client->id,
            'email'     => $client->email,
            'name'      => $client->name
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
        $client->email = $client->email . '_old';
        $client->save();
        $client->delete();

        return json_encode([
            'success'   => 'The Client has been deleted.',
            'method'    => 'delete',
            'id'        => $client->id,
        ]);
    }
}
