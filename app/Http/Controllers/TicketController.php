<?php

namespace TargetInk\Http\Controllers;

use Illuminate\Http\Request;
use TargetInk\Http\Requests;
use TargetInk\Http\Controllers\Controller;

use TargetInk\Ticket;
use TargetInk\Http\Requests\TicketRequest;

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
        $tickets = \Auth::user()->Tickets()->where('archived', '=', $archived)->orderBy('order', 'desc')->get();
        return View('tickets.ticketList', compact('archived', 'tickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('tickets.ticketEdit');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ticket = Ticket::find($id);
        return View('tickets.ticketEdit', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TicketRequest $request, $id)
    {
        $ticket = Ticket::find($id);
        $ticket->fill($request->all());
        $ticket->save();
        return \Redirect::to('/tickets');
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
        return \Redirect::back()->with('success', 'The ticket has been successfully archived');
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
        return \Redirect::back()->with('success', 'The ticket has been successfully unarchived');
    }
}
