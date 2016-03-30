<?php

namespace TargetInk\Http\Controllers;

use Illuminate\Http\Request;
use TargetInk\Http\Requests;
use TargetInk\Http\Requests\DocumentSeoCreateRequest;
use TargetInk\Http\Requests\DocumentSeoDeleteRequest;
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
        $documentList = view('dashboard.documents.documentList', compact('type'));
        if(request()->ajax()) {
            return $documentList;
        } else {
            return view('dashboard', compact('documentList'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type)
    {
        $documentForm = view('dashboard.documents.documentEdit', compact('type'));
        if(request()->ajax()) {
            return $documentForm;
        } else {
            $documentList = view('dashboard.documents.documentList', compact('type'));
            return view('dashboard', compact('documentList', 'documentForm'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocumentSeoCreateRequest $request, $type)
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

            $fileobj->filepath = $filename;
        }

        $client = User::find($fileobj->client_id);

        Mail::send('emails.newSeo', ['user' => $client, 'file' => $fileobj], function ($message) use ($client) {
            $message->to($client->email);

            if($client->second_email) {
                $message->bcc($client->second_email);
            }

            $message->subject('Your latest SEO review - ' .  date('d/m/Y'));
        });

        $fileobj->save();
        return redirect()->back()->with('success', 'The ' . ucfirst($type) . ' Document has been added');
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

        $documentTable = view('dashboard.documents.documentShow', compact('client', 'type'));
        if(request()->ajax()) {
            return $documentTable;
        } else {
            // Always show the form for direct hits
            $documentForm = view('dashboard.documents.documentEdit', compact('type'));
            $documentList = view('dashboard.documents.documentList', compact('type'));
            return view('dashboard', compact('documentList', 'documentTable', 'documentForm'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DocumentSeoDeleteRequest $request, $type, $id)
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
