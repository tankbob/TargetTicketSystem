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

use Storage;
use Image;
use Mail;

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
        if($client) {
            $tickets = $client->tickets()->where('archived', '=', $archived)->orderBy('order', 'desc')->get();
        } else {
            abort(404);
        }

        $counter = 0;
        foreach($tickets as $ticket) {
            $counter++;
            if($counter == 1) {
                $ticket->first = true;
            } else {
                $ticket->first = false;
            }

            if($counter == count($tickets)) {
                $ticket->last = true;
            } else {
                $ticket->last = false;
            }
        }

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
        $client = User::where('company_slug', $company_slug)->first();

        if($request->published_at) {
            $published_at_date = explode('/', $request->published_at);
            if(is_array($published_at_date) && isset($published_at_date[0]) && isset($published_at_date[1]) && isset($published_at_date[2])) {
                $published_at_date = $published_at_date[2]. '-' . $published_at_date[1]. '-' . $published_at_date[0];
            } else {
                $published_at_date = '0000-00-00';
            }
        } else {
            $published_at_date = '0000-00-00';
        }

        $ticket = new Ticket;
        $ticket->fill($request->all());
        $ticket->client_id = $client->id;
       
        $order = Ticket::where('client_id', '=', $client->id)->where('archived', '=', 0)->orderBy('order', 'desc')->first();
        
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

        // Send an email
        foreach([$client->email => $client->instant, config('app.email_to') => false] as $recipientEmail => $recipientInstantKey) {
            Mail::send('emails.newTicket', ['instant' => $recipientInstantKey, 'user' => $client, 'response' => $response, 'ticket' => $ticket], function ($message) use ($client, $response, $ticket, $recipientEmail) {
                $message->to($recipientEmail);

                $priority = '';
                if($ticket->priority) {
                    $priority = 'PRIORITY ';
                }

                $message->subject($priority . 'Support Request:' . $ticket->getRef());
            });
        }

        return redirect('/')->with('ticket_success', true)->with('company_slug', $company_slug);
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
            $query .= ' WHEN ' . $id . ' THEN ' . (count($new_order)-$order);
        }

        $query .= " END WHERE id IN (";

        foreach($new_order as $order => $id) {
            $query .= $id . ',';
        }

        $query = rtrim($query, ",");

        $query .= ")";

        \DB::update($query);
    }

    public function move(Request $request, $direction, $user_id, $ticket_id, $archived) {
        $tickets = Ticket::where('client_id', $user_id)->where('archived', $archived)->orderBy('order', 'asc')->get();

        // Set initial order in case it has never been set
        $order = 0;
        foreach($tickets as $ticket) {
            $order++;
            $ticket->order = $order;
        }

        $previous = null;
        $current = null;
        foreach($tickets as $ticket) {
            if($direction == 'down') {
                if($previous) {
                    if($ticket_id == $ticket->id) {
                        // Swap the orders with the previous one
                        $tmp = $previous->order;
                        $previous->order = $ticket->order;
                        $ticket->order = $tmp;
                        unset($tmp);

                        $previous->save();
                        $ticket->save();
                    }
                }
            } elseif($direction == 'up') {
                if($current) {
                    // Current has been set, so swap it with the previous
                    $tmp = $ticket->order;
                    $ticket->order = $current->order;
                    $current->order = $tmp;
                    unset($tmp);

                    $current->save();
                    $ticket->save();

                    break;
                }
                
                if($ticket_id == $ticket->id) {
                    $current = $ticket;
                }
            } else {
                abort(500, 'Invalid direction');
            }

            $previous = $ticket;
        }

        return redirect()->back()->with('success', 'Successfully moved ticket');
    }

    public function addResponse($company_slug, $ticket_id, ResponseRequest $request)
    {
        $response = new Response;
        $response->fill($request->all());
        if($request->has('working_time')) {
            $wt = explode(':', $request->get('working_time'));
            if(is_array($wt) && isset($wt[0]) && isset($wt[1])) {
                $response->working_time = 60*$wt[0]+$wt[1];
            }
        }
        $response->admin = \Auth::user()->admin;
        $response->ticket_id = $ticket_id;
        $response->save();

        self::processFileUpload($request, $response->id);
        flash()->success('The response has been sent.');

        // Send an email
        $client = User::where('company_slug', $company_slug)->first();
        $ticket = Ticket::find($response->ticket_id);

        $recipients = [$client->email => $client->instant];
        if(!auth()->user()->admin) {
            $recipients[config('app.email_to')] = false;
        }
        
        foreach($recipients as $recipientEmail => $recipientInstantKey) {
            Mail::send('emails.newTicketReply', ['instant' => $recipientInstantKey, 'user' => $client, 'response' => $response, 'ticket' => $ticket], function ($message) use ($client, $response, $ticket, $recipientEmail) {
                $message->to($recipientEmail);

                $priority = '';
                if($ticket->priority) {
                    $priority = 'PRIORITY ';
                }

                $message->subject($priority . 'Support Request:' . $ticket->getRef());
            });
        }

        return redirect()->back();
    }

    public function processFileUpload($request, $response_id) {
        // Loop through attachments
        foreach($request->all() as $request_key => $request_val) {
            if(substr($request_key, 0, 10) == 'attachment') {
                // We are uploading a file
                if($request->hasFile($request_key) && $request->file($request_key)->isValid()) {
                    $file = $request->file($request_key);
                    $extension = $file->getClientOriginalExtension();
                    $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $filename .= '_' . time() . '.' . $extension;

                    // Sanitize
                    $filename = mb_ereg_replace("([^\w\s\d\-_~,;:\[\]\(\).])", '', $filename);
                    $filename = mb_ereg_replace("([\.]{2,})", '', $filename);

                    if(in_array($extension, ['jpg', 'jpeg', 'gif', 'png'])) {
                        $doctype = 'I';
                    } else {
                        $doctype = 'D';
                    }

                    Storage::disk('s3')->put($filename, file_get_contents($request->file($request_key)->getRealPath()));

                    $attachment = new Attachment;
                    $attachment->type = $doctype;
                    $attachment->original_filename = $file->getClientOriginalName();
                    $attachment->filename = $filename;
                    $attachment->response_id = $response_id;
                    $attachment->save();
                }
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
