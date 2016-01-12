<?php

namespace TargetInk\Http\Controllers;

use Illuminate\Http\Request;

use TargetInk\Http\Requests;
use TargetInk\Http\Controllers\Controller;

use TargetInk\User;
use TargetInk\File;
use Storage;
use Mail;

class AdminDocumentsController extends Controller
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
    public function index($type)
    {
        $clients = null;
        if(auth()->user()->admin) {
            $clients = User::where('admin', 0)->orderBy('company')->lists('web', 'id')->toArray();
        }
        return view('dashboard.documents.documentList', compact('clients', 'type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type)
    {
        return view('dashboard.documents.documentEdit', compact('type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($type, Request $request)
    {
        $fileobj = new File;
        $fileobj->fill($request->all());

        if($type == 'seo') {
            $fileobj->type = 0;
        } else {
            $fileobj->type = 1;
        }

        if($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
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

            Storage::disk('s3')->put($filename, file_get_contents($request->file('file')->getRealPath()));

            $fileobj->filepath = config('app.asset_url') . $filename;
        }

        $client = User::find($fileobj->client_id);

        Mail::send('emails.newSeo', ['user' => $client, 'file' => $fileobj], function ($message) use ($client) {
            $message->to($client->email);
            $message->subject('Your latest SEO review from Target Ink Ltd - ' .  date('d/m/Y'));
        });

        $fileobj->save();
        return redirect('/?' . $type . '&client_id=' . $request->get('client_id') . '#' . $type . '-div');
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

        if(auth()->user()->admin && $id) {
            $client = User::find($id);
        }

        return view('dashboard.documents.documentShow', compact('client', 'type'));
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
            'success'   => 'The ' . $type . ' document has been deleted.',
            'method'    => 'delete',
            'id'        => $id,
        ]);
    }
}
