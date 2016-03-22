@extends('layouts.app');

@section('content')
    <table class="table table-hover center-block" style="width:70%">
        @foreach($notifications as $notification)
            <tr class="notification_row" href="{{$notification->notification_link}}">
                <td class="notification_desc">
                    {{$notification->notification_description}}
                </td>
                <td class="notification_date">
                    {{ date("F j, Y, g:i a",strtotime($notification->created_at)) }}
                </td>
                <td class="mark_as_unread">
                    <a href="#" value="{{$notification->id}}">Mark as unread</a>
                </td>
            </tr>
        @endforeach

    </table>

    <style>
        .notification_row{
            cursor: pointer;
        }
        .notification_row:hover
        {
            background-color: rgba(0,0,0,0.05) !important;
        }
    </style>
    <script>
        $('.notification_desc').click(function(){
            window.location.href = $(this).parent().attr('href');
        });
        $('.notification_date').click(function(){
            window.location.href = $(this).parent().attr('href');
        });
        $('.mark_as_unread a').click(function(){
            var notification_id = $(this).attr('value');
            $.ajax({
                'url' : "{{url('/mark_notification/')}}"+notification_id,
                'success' : function(data)
                {
                    
                }
            });
        });
    </script>

@endsection