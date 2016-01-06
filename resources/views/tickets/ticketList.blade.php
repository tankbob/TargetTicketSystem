@extends('includes.layout')

@section('sectionTitle')
    Your Tickets
@stop

@section('content')
<script>
    @if($archived)
    var $archived = true;
    @else
    var $archived = false;
    @endif

    var $client_id = {{ $client->id }};
</script>

@if(!auth()->user()->admin)
<div class="page-heading text-center">
    <a href="{{ url($client->company_slug . '/tickets/create') }}" class="btn btn-info btn-new-ticket">CREATE A NEW TICKET</a>
</div>
@endif

@include('flash::message')

<div class="page-content row">
    <div class="col-xs-12">
        <div class="border-b ticket-pad">
            <a href="{{ url($client->company_slug . '/tickets') }}" class="btn-open-tickets @if(!$archived) active @endif "><i></i> View Open Tickets</a>
            <a href="{{ url($client->company_slug . '/tickets?archived=1') }}" class="btn-archived-tickets @if($archived) active @endif "><i></i> View Archived Tickets</a>
        </div>
    </div>
    <div class="col-xs-12">
        <table class="table text-muted table-muted table-no-borders no-margin">
            <tr>
                <td class="hidden-sm hidden-xs goto-column">
                    <i class="icon-goto"></i>
                </td>
                <td class="td-adjust hidden-xs">
                    Double Click to View Ticket
                </td>
                <td class="td-adjust text-right hidden-xs">
                    Click &amp; Drag to Reprioritise Ticket
                </td>
                <td class="td-adjust visible-xs">
                    Tap to View Ticket
                </td>
                <td class="td-adjust text-right visible-xs">
                    Tap to Reprioritise Ticket
                </td>
                <td width="36" class="hidden-xs">
                    <i class="icon-move icon-muted"></i>
                </td>
            </tr>
        </table>
    </div>
    <div class="col-xs-12">
        @if(count($tickets))
            <table class="table ticket-table sorted_table" id="ticket_table">
                <thead>
                    <tr>
                        <th class="hidden-sm hidden-xs goto-column"></th>
                        <th>Ticket Title</th>
                        <th class="hidden-sm hidden-xs">Ref No.</th>
                        <th class="hidden-xs">Ticket Type</th>
                        <th class="hidden-xs">Cost</th>
                        <th class="text-center">Response</th>
                        @if($archived)
                        <th class="text-center hidden-xs">Unarchive</th>
                        @else
                        <th class="text-center hidden-xs">Archive</th>
                        @endif
                        @if(auth()->user()->admin)
                            <th class="hidden-xs">Time</th>
                            <th class="hidden-xs"></th>
                        @endif
                        <th width="36"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tickets as $ticket)
                        <tr id="{{ $ticket->id }}">
                            <td class="hidden-sm hidden-xs"><a href="/{{$client->company_slug}}/tickets/{{$ticket->id}}" class="show-on-hover icon-goto"></a></td>
                            <td class="td-adjust">{{ $ticket->title }}</td>
                            <td class="td-adjust hidden-sm hidden-xs">{{ $ticket->getRef() }}</td>
                            <td class="td-adjust hidden-xs">
                                @if($ticket->type == 1)
                                    Web Amends
                                @elseif($ticket->type == 2)
                                    Add Content
                                @elseif($ticket->type == 3)
                                    Get Quote
                                @elseif($ticket->type == 4)
                                    Ask Question
                                @endif
                            </td>
                            <td class="td-adjust hidden-xs">@if($ticket->cost) &pound;{{ $ticket->cost }} @else N/A @endif</td>
                            <td class="text-center">
                                @if(@$ticket->responses->last()->admin)
                                <i class="icon-response"></i>
                                @endif
                            </td>
                            @if($archived)
                            <td class="text-center hidden-xs">
                                <a href="/{{$client->company_slug}}/tickets/{{$ticket->id}}/unarchive" class="btn-unarchive"></a>
                            </td>
                            @else
                            <td class="text-center hidden-xs">
                                <a href="/{{$client->company_slug}}/tickets/{{$ticket->id}}/archive" class="btn-archive"></a>
                            </td>
                            @endif
                            @if(auth()->user()->admin)
                                <th class="td-adjust hidden-xs">{{$ticket->totalTime()}}</th>
                                <td class="td-adjust text-center hidden-xs">
                                    {!! Form::open(['url' => '/'.$client->company_slug.'/tickets/'.$ticket->id, 'method' => 'DELETE']) !!}
                                        {!! Form::submit('', ['class' => 'btn-delete icon-delete']) !!}
                                    {!! Form::close() !!}
                                </td>
                            @endif
                            <td class="hidden-xs"><i class="show-on-hover icon-move"></i></td>
                            <td class="visible-xs">
                                <div>
                                    <a href="{{ url('api/move/ticket/up/' . $client->id . '/' . $ticket->id . '/' . $archived) }}" class="mobile-order-icon" @if($ticket->first) style="visibility:hidden" @endif ><i class="fa fa-2x fa-caret-up"></i></a>
                                </div>
                                <div>
                                    <a href="{{ url('api/move/ticket/down/' . $client->id . '/' . $ticket->id . '/' . $archived) }}" class="mobile-order-icon" @if($ticket->last) style="visibility:hidden" @endif><i class="fa fa-2x fa-caret-down"></i></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-warning">There are no tickets to show</div>
        @endif
    </div>
</div>
@stop
