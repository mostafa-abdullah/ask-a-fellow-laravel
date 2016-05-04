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
        <h2>Send mail to {{$user->first_name.' '.$user->last_name}}</h2>
        <br>
        <form method="POST" action="{{url('/mail/0')}}">
            {{csrf_field()}}
            <input type="hidden" name="user_id" value="{{$user->id}}">
            <div class="form-group">
                <label for="mail_subject">Mail Subject</label>
                <input type="text" class="form-control" id="mail_subject" name="mail_subject" placeholder="Subject">
            </div>
            <h4 class="mail_example">Hello {{$user->first_name}}, </h4>
            <div class="form-group">
                <label for="mail_content">Mail Body</label>
                <textarea class="form-control" id="mail_content" name="mail_content" placeholder="Mail Body"></textarea>
            </div>
            <h4 class="mail_example">Regards,</h4>
            <h4 class="mail_example">TechHub Development Team</h4>


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
    </style>

@endsection