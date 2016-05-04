@extends('layouts.app')

@section('content')
<div class="container" style="width: 90%; padding-left: 50px">
    @if (session('mail'))
        <div class="flash-message">
            <div class="alert alert-info" style="background-color: #FFAF6C; border-color: #FF6B2D; color:#AA5B0B">
                {{session('mail')}}
            </div>
        </div>
    @endif
    <form method="POST" action="{{url('/mail/1')}}">
        {{csrf_field()}}
        <div class="form-group">
            <label for="mail_subject">Mail Subject</label>
            <input type="text" class="form-control" id="mail_subject" name="mail_subject" placeholder="Subject">
        </div>
        <h4 class="mail_example">Hello awesome Ask a Fellow member, </h4>
        <div class="form-group">
            <label for="mail_content">Mail Body</label>
            <textarea class="form-control" id="mail_content" name="mail_content" placeholder="Mail Body"></textarea>
        </div>
        <h4 class="mail_example">Regards,</h4>
        <h4 class="mail_example">TechHub Development Team</h4>
        <div class="form-group">
            <br>
            <label for="majors">Choose receipents</label>
            <br>
            <a id="select_all">Select all</a>
            <a id="unselect_all">Unselect all</a>
            <br>
            @foreach($users as $user)
                <input class="recepient_check" type="checkbox" name="users[]" value="{{$user->id}}"> {{$user->first_name.' '.$user->last_name}}
                <a href="{{url('/admin/mail/one/'.$user->id)}}">Email individually.</a>
                <br>
            @endforeach
        </div>

        <button type="submit" class="btn btn-default">Send Mail</button>

        <div class="error" style="color:red">
            @include('errors')
        </div>

    </form>
</div>

    <style>
        .mail_example {
            font-style: italic;
            color:#0000ff;
        }
        #select_all, #unselect_all {
            cursor: pointer;
            text-decoration: none;
        }
    </style>

    <script>
        $(document).ready(function(){
            $('#unselect_all').hide();
        });

        var checked = false;
        $('#select_all').click(function(){
            var checkBoxes = $('.recepient_check');
            checkBoxes.prop("checked", !checked);
            checked = !checked;
            if(!checked)
                    $(this).text("Select all");
            else
                    $(this).text("Unselect all");
        });


    </script>

@endsection