<?php

namespace TargetInk\Http\Controllers;

use Illuminate\Http\Request;
use TargetInk\Http\Requests;
use TargetInk\Http\Controllers\Controller;

use TargetInk\Ticket;
use TargetInk\Response;
use TargetInk\Attachment;
use TargetInk\Http\Requests\TicketRequest;
use TargetInk\Http\Requests\ResponseRequest;


class TicketController extends Controller
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
    public function index()
    {
        if(\Request::has('archived')){
            $archived = 1;
        }else{
            $archived = 0;
        }
        $client_id = \Auth::user()->id;
        $tickets = \Auth::user()->Tickets()->where('archived', '=', $archived)->orderBy('order', 'desc')->get();
        return view('tickets.ticketList', compact('archived', 'tickets', 'client_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tickets.ticketEdit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TicketRequest $request)
    {
        $ticket = new Ticket;
        $ticket->fill($request->all());
        $ticket->client_id = \Auth::user()->id;
        $order = Ticket::where('client_id', '=', \Auth::user()->id)->where('archived', '=', 0)->orderBy('order', 'desc')->first();
        if($order){
            $order = $order->order +1;
        }else{
            $order = 1;
        }
        $ticket->order = $order;
        $ticket->save();

        $response = new Response;
        $response->fill($request->all());
        $response->ticket_id = $ticket->id;
        $response->admin = \Auth::user()->admin;
        $response->save();

        self::processFileUpload($request, $response->id);
        
        return \Redirect::to('/ticketsuccess');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ticket = Ticket::with('responses')->with('responses.attachments')->find($id);
        $times = $ticket->responses->where('admin', 1)->lists('working_time');
        $total_working_time = 0;
        foreach($times as $t){
            if($t){
                $t = explode(':', $t);
                $total_working_time += 60 * $t[0];
                $total_working_time += $t[1];
            }
        }
        $total_working_time = floor($total_working_time/60).':'.sprintf('%02d', $total_working_time%60);
        return view('tickets.ticketShow', compact('ticket', 'total_working_time'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    /*    $ticket = Ticket::find($id);
        return view('tickets.ticketEdit', compact('ticket')); */
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
        $ticket = Ticket::find($id);
        $ticket->type = ($request->get('type'));
        $ticket->save();
        return \Redirect::back()->with('success', 'The ticket type has been changed.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function success(){
        return View('tickets.ticketSuccess');
    }

    public function archive($id){
        $ticket = Ticket::find($id);
        $ticket->archived = 1;
        $order = Ticket::where('client_id', '=', \Auth::user()->id)->where('archived', '=', 1)->orderBy('order', 'desc')->first();
        if($order){
            $order = $order->order +1;
        }else{
            $order = 1;
        }
        $ticket->order = $order;
        $ticket->save();
        flash()->success('The ticket has been successfully archived.');
        return \Redirect::back();
    }

    public function unarchive($id){
        $ticket = Ticket::find($id);
        $ticket->archived = 0;
        $order = Ticket::where('client_id', '=', \Auth::user()->id)->where('archived', '=', 0)->orderBy('order', 'desc')->first();
        if($order){
            $order = $order->order +1;
        }else{
            $order = 1;
        }
        $ticket->order = $order;
        $ticket->save();
        flash()->success('The ticket has been successfully unarchived.');
        return \Redirect::back();
    }

    public function setOrder(){
        $user_id = \Request::get('user_id');
        $archived = \Request::get('archived');
        $new_order = \Request::get('new_order');

        $tickets = Ticket::where('client_id', '=', $user_id)->where('archived', '=', $archived)->whereIn('id', $new_order)->get();

        $query = "UPDATE tickets SET tickets.order = CASE id ";

        foreach($new_order as $order => $id){
            //ORDER IS REVERSE CAUSE WHEN U ADD A NEW ONE IS MAX ORDER +1 AND SHOULD APPEAR FIRST
            $query .= ' WHEN '.$id.' THEN '.(count($new_order)-$order);
        }


        $query .= " END WHERE id IN (";

        foreach($new_order as $order => $id){
            $query .= $id.',';
        }

        $query = rtrim($query, ",");

        $query .= ")";

        \DB::update($query);
    }

    public function addResponse($ticket_id, ResponseRequest $request){

        $response = new Response;
        $response->fill($request->all());
        $response->admin = \Auth::user()->admin;
        $response->ticket_id = $ticket_id;
        $response->save();

        self::processFileUpload($request, $response->id);
        flash()->success('The response has been sent.');
        return \Redirect::back();
    }

    public function processFileUpload($request, $response_id){
        for($counter = 1; $counter <= $request->get('attachment_count'); $counter ++){
            if(\Request::hasFile('attachment-'.$counter) && $request->file('attachment-'.$counter)->isValid()){
                $file = $request->file('attachment-'.$counter);
                $extension = $file->getClientOriginalExtension();
                $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $filename .= '_'.time().'.'.$extension;
                
                if(in_array($extension, ['jpg', 'jpeg', 'gif', 'png'])){
                    $img = \Image::make($file);
                    if($img->width() > 510){
                        $img->resize(510, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }
                    $img->save(public_path().'/files/tickets/'.$filename);
                    $doctype = 'I';
                }else{
                    $file->move(public_path().'/files/tickets', $filename);
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
}
