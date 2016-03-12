@extends('layouts.app');
@section('content')
    <div class=info_section>
        <div class="profile_picture">
            @if($user->profile_picture)
                <img src="{{asset($user->profile_picture)}}" style="">
            @else
                <img src="{{asset('art/default_pp.png')}}" style="">
            @endif

        </div>
        <h1>{{$user->first_name.' '.$user->last_name}}</h1>
        <a href="#" style="color:#0057A2">{{$user->email}}</a>
        <p style="font-size: 20px;">{{$user->semester?'Semester '.$user->semester:''}} {{$user->major?$user->semester:''}}</p>
        <p>{{$user->bio}}</p>
    </div>
    <div class="questions_answers">
        <nav id="switch" class="center-block cl-effect-21" style="text-align:center;width: 100%; height: 70px;">
            <a id="loginSwitch" style="margin-right:3%; color: #CA6A1B;  margin-left:5%; margin-bottom:15px; border-bottom:1px solid #CA6A1B;" href="#questions">Questions</a>
            <a id="registerSwitch" style="opacity:0.5;margin-left:3%;color: #CA6A1B;  margin-right:5%; border-bottom:1px solid #CA6A1B;" href="#answers">Answers</a>
        </nav>
        <h3>Mostafa asked {{count($user->questions()->get())}} question(s).</h3>
        <br>
        @foreach($user->questions()->get() as $question)
            <div class="media">
                <div style="text-align: center" class="media-left">
                    <a href="#">
                        <img class="media-object" src="{{asset('art/default_pp.png')}}" alt="...">
                    </a>
                    @if($question->votes > 0)
                        <span style="color:green;">{{$question->votes}} <span class="glyphicon glyphicon-thumbs-up"></span></span>
                    @elseif($question->votes == 0)
                        <span style="">{{$question->votes}} <span class="glyphicon glyphicon-thumbs-up"></span></span>
                    @else
                        <span style="color:red;">{{$question->votes}} <span class="glyphicon glyphicon-thumbs-down"></span></span>
                    @endif

                </div>
                <div class="media-body">
                    <h4 class="media-heading">{{substr($question->question,0,50).'...'}}</h4>
                    {{substr($question->question,0,300).'....'}}<a href="#">See more.</a>
                    <p style="font-weight: bold; font-style: italic; font-size: 13px;">{{ date("F j, Y, g:i a",strtotime($question->created_at)) }} </p>
                </div>

            </div>
        @endforeach


    </div>


    <link href="{{asset('css/textAnimation.css')}}" rel="stylesheet">
    <style>
        /* Profile styling */

        #main_content{

            padding-top: 0px !important;
            padding-bottom: 50px !important;
            /*height: 800px;*/
            width: 80% !important;
            background-color: #F7E8D6;
            margin-top: 30px !important;
            margin-bottom: 10px ;
            box-shadow: 0px 5px 10px -1px #888888;
            z-index: 1;
        }

        .info_section
        {
            height: 400px;
            background-color: #FF953D;
            text-align: center;
            padding: 40px;
        }
        .profile_picture
        {




        }
        .profile_picture img{
            /*position: relative;*/
            /*display: inline-block;*/
            width: 200px;
            height: 200px;
            border-radius: 100px;
            object-fit: cover;
        }
        .info_section h1
        {
            font-size: 40px;
            color: #621708;
            font-family: 'ubuntu';
        }
        .info_section p{

        }

        .questions_answers{
            padding: 50px;
            padding-left: 100px;
            margin-top: 20px;
        }
        .questions_answers .media
        {
            width: 70%;
            min-width: 200px;
            margin-bottom: 50px;
        }
        .questions_answers .media img
        {
            width: 70px;
            height: 70px;
            border-radius: 100px;
            margin-bottom: 10px;
        }
        .questions_answers .media h4
        {
            /*width: 100%;*/
            /*font-size: 17px;*/
            font-weight: bold;
        }



        @media (max-width: 600px) {
            .profile_picture img{
                width: 100px;
                height: 100px;
            }
            .info_section
            {
                font-size: 14px;
            }
            .info_section h1
            {
                font-size: 25px;
            }
            .questions_answers{

                padding-left: 20px;

            }
            .questions_answers .media
            {
                width: 100%;
                font-size: 13px;
            }
            .questions_answers .media h4
            {
                /*width: 100%;*/
                font-size: 17px;
                font-weight: bold;
            }

            #switch a
            {
                font-size: 13px !important;
            }
            #main_content h3
            {
                font-size: 18px;
            }


        }



    </style>

@endsection