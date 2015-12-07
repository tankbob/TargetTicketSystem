<?php

namespace TargetInk\Http\Controllers;

use Illuminate\Http\Request;
use TargetInk\Http\Requests;
use TargetInk\Http\Controllers\Controller;

use TargetInk\Http\Middleware\OwnCompany;

use TargetInk\Ticket;
use TargetInk\Response;
use TargetInk\Attachment;
use TargetInk\User;
use TargetInk\Http\Requests\TicketRequest;
use TargetInk\Http\Requests\ResponseRequest;


class TicketController extends Controller
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
    public function index(Request $request, $company_slug)
    {
        if($request->has('archived')) {
            $archived = 1;
        } else {
            $archived = 0;
        }
        $client = User::where('company_slug', $company_slug)->first();
        $tickets = $client->Tickets()->where('archived', '=', $archived)->orderBy('order', 'desc')->get();
        return view('tickets.ticketList', compact('archived', 'tickets', 'client'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($company_slug)
    {
        return view('tickets.ticketEdit', compact('company_slug'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($company_slug, TicketRequest $request)
    {
        $client_id = User::where('company_slug', $company_slug)->first()->id;
        if($request->published_at) {
            $published_at_date = explode('/', $request->published_at);
            $published_at_date = $published_at_date[2]. '-' . $published_at_date[1]. '-' . $published_at_date[0];
        } else {
            $published_at_date = '0000-00-00';
        }
        $ticket = new Ticket;
        $ticket->fill($request->all());
        $ticket->client_id = $client_id;
        $order = Ticket::where('client_id', '=', $client_id)->where('archived', '=', 0)->orderBy('order', 'desc')->first();
        if($order) {
            $order = $order->order +1;
        } else {
            $order = 1;
        }
        $ticket->order = $order;
        $ticket->save();

        $response = new Response;
        $response->fill($request->all());
        $response->ticket_id = $ticket->id;
        $response->admin = \Auth::user()->admin;
        $response->published_at = $published_at_date;
        $response->save();

        self::processFileUpload($request, $response->id);

        return view('tickets.ticketSuccess', compact('company_slug'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($company_slug, $ticket_id)
    {

        $ticket = Ticket::with('responses')->with('responses.attachments')->find($ticket_id);
        if($ticket->client->company_slug != $company_slug) {
            return redirect('/');
        }
         return view('tickets.ticketShow', compact('ticket', 'company_slug'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /*
        $ticket = Ticket::find($id);
        return view('tickets.ticketEdit', compact('ticket'));
        */
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $company_slug, $id)
    {
        $ticket = Ticket::find($id);
        if($ticket->client->company_slug != $company_slug) {
            return redirect('/');
        }
        $ticket->type = ($request->get('type'));
        $ticket->cost = ($request->get('cost'));
        $ticket->save();
        flash()->success('The ticket has been changed.');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($company_slug, $id)
    {
        $ticket = Ticket::find($id);
        if($ticket->client->company_slug != $company_slug) {
            return redirect('/');
        }
        $ticket->delete();
        flash()->success('The ticket has been deleted.');
        return redirect()->back();
    }

    public function archive($company_slug, $ticket_id) {
        $ticket = Ticket::find($ticket_id);
        if($ticket->client->company_slug != $company_slug) {
            return redirect('/');
        }
        $client_id = User::where('company_slug', $company_slug)->first()->id;
        $ticket->archived = 1;
        $order = Ticket::where('client_id', '=', $client_id)->where('archived', '=', 1)->orderBy('order', 'desc')->first();
        if($order) {
            $order = $order->order +1;
        } else {
            $order = 1;
        }
        $ticket->order = $order;
        $ticket->save();
        flash()->success('The ticket has been successfully archived.');
        return redirect()->back();
    }

    public function unarchive($company_slug, $ticket_id) {
        $ticket = Ticket::find($ticket_id);
        if($ticket->client->company_slug != $company_slug) {
            return redirect('/');
        }
        $client_id = User::where('company_slug', $company_slug)->first()->id;
        $ticket->archived = 0;
        $order = Ticket::where('client_id', '=', $client_id)->where('archived', '=', 0)->orderBy('order', 'desc')->first();
        if($order) {
            $order = $order->order +1;
        } else {
            $order = 1;
        }
        $ticket->order = $order;
        $ticket->save();
        flash()->success('The ticket has been successfully unarchived.');
        return redirect()->back();
    }

    public function setOrder(Request $request) {
        $user_id = $request->input('user_id');
        $archived = $request->input('archived');
        $new_order = $request->input('new_order');

        $tickets = Ticket::where('client_id', '=', $user_id)->where('archived', '=', $archived)->whereIn('id', $new_order)->get();

        $query = "UPDATE tickets SET tickets.order = CASE id ";

        foreach($new_order as $order => $id) {
            //ORDER IS REVERSE CAUSE WHEN U ADD A NEW ONE IS MAX ORDER +1 AND SHOULD APPEAR FIRST
            $query .= ' WHEN ' . $id.' THEN ' .(count($new_order)-$order);
        }


        $query .= " END WHERE id IN (";

        foreach($new_order as $order => $id) {
            $query .= $id.',';
        }

        $query = rtrim($query, ",");

        $query .= ")";

        \DB::update($query);
    }

    public function addResponse($company_slug, $ticket_id, ResponseRequest $request)
    {
        $response = new Response;
        $response->fill($request->all());
        if($request->has('working_time')) {
            $wt = explode(':', $request->get('working_time'));
            $response->working_time = 60*$wt[0]+$wt[1];
        }
        $response->admin = \Auth::user()->admin;
        $response->ticket_id = $ticket_id;
        $response->save();

        self::processFileUpload($request, $response->id);
        flash()->success('The response has been sent. ');
        return redirect()->back();
    }

    public function processFileUpload($request, $response_id) {
        for($counter = 1; $counter <= $request->get('attachment_count'); $counter ++) {
            if($request->hasFile('attachment-' . $counter) && $request->file('attachment-' . $counter)->isValid()) {
                $file = $request->file('attachment-' . $counter);
                $extension = $file->getClientOriginalExtension();
                $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $filename .= '_' .time() . ' . ' . $extension;

                if(in_array($extension, ['jpg', 'jpeg', 'gif', 'png'])) {
                    $img = \Image::make($file);
                    if($img->width() > 510) {
                        $img->resize(510, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }
                    $img->save(public_path() . '/files/tickets/' . $filename);
                    $doctype = 'I';
                } else {
                    $file->move(public_path() . '/files/tickets', $filename);
                    $doctype = 'D';
                }

                $attachment = new Attachment;
                $attachment->type = $doctype;
                $attachment->original_filename = $file->getClientOriginalName();
                $attachment->filename = $filename;
                $attachment->response_id = $response_id;
                $attachment->save();
            }
        }
    }

    public function editResponseTime(Request $request, $company_slug, $ticket_id, $response_id) {
        $ticket = Ticket::find($ticket_id);
        if($ticket->client->company_slug != $company_slug) {
            return redirect('/');
        }
        $response = Response::find($response_id);
        if($response->ticket_id != $ticket_id) {
            return redirect('/');
        }
        if($request->has('working_time')) {
            $wt = explode(':', $request->get('working_time'));
            $response->working_time = 60*$wt[0]+$wt[1];
        }
        $response->save();

        flash()->success('The response has been updated.');
        return redirect()->back();
    }
}
