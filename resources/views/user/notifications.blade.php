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
                <td style="width: 150px;">
                    @if($notification->seen)
                        <a class="mark_as_unread" href="#" value="{{$notification->id}}">Mark as unread</a>
                    @else
                        <a class="mark_as_read" href="#" value="{{$notification->id}}">Mark as read</a>
                    @endif
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
        $(document).ready(function(){
            $('.mark_as_read').hide();
            $('.mark_as_unread').hide();
        });
        $('.notification_desc').click(function(){
            window.location.href = $(this).parent().attr('href');
        });
        $('.notification_date').click(function(){
            window.location.href = $(this).parent().attr('href');
        });
        $(document).on('click','.mark_as_unread',function(){
            var notification_id = $(this).attr('value');
            var notification = $(this);
            $.ajax({
                'url' : "{{url('/mark_notification')}}"+"/"+notification_id+"/0",
                'success' : function(data)
                {
                   notification.parent().html(data);
                }
            });
        });

        $(document).on('click','.mark_as_read',function(){
            var notification_id = $(this).attr('value');
            var notification = $(this);
            $.ajax({
                'url' : "{{url('/mark_notification')}}"+"/"+notification_id+"/1",
                'success' : function(data)
                {
                    notification.parent().html(data);
                }
            });
        });


        $(document).on('mouseenter','.notification_row',function(){
            $(this).find('.mark_as_unread').show();
            $(this).find('.mark_as_read').show();
        });
        $(document).on('mouseleave','.notification_row',function(){
            $(this).find('.mark_as_unread').hide();
            $(this).find('.mark_as_read').hide();
        });

    </script>

@endsection