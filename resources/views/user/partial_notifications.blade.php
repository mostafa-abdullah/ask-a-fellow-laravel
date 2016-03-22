
<table class="table table-hover">
@foreach($notifications as $notification)
<tr class="notification_row" href="{{$notification->notification_link}}">
    <td class="notification_desc">
        {{$notification->notification_description}}
    </td>
    <td class="notification_date">
        {{ date("F j, Y, g:i a",strtotime($notification->created_at)) }}
    </td>
</tr>
@endforeach

</table>
<a href="{{url('/notifications')}}">View all notifications</a>
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
    $('.notification_row').click(function(){
       window.location.href = $(this).attr('href');
    });
</script>