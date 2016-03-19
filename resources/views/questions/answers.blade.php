<?php
    $order = 'votes';
    if(isset($_GET['sort']))
        $order = $_GET['sort'];
    $allowed = ['votes','oldest','latest'];
    if(!in_array($order,$allowed))
        $order = 'votes';


    $answers = array();
    if($order == 'votes')
        $answers = $question->answers()->orderBy('votes','desc')->orderBy('created_at','desc')->get();
    elseif($order == 'oldest')
        $answers = $question->answers()->orderBy('created_at','asc')->get();
    elseif($order == 'latest')
        $answers = $question->answers()->orderBy('created_at','desc')->get();
    else
        $answers = $question->answers()->orderBy('votes','desc')->orderBy('created_at','desc')->get();




?>

@extends('layouts.app')
@section('content')
    <link href="{{asset('/css/formInput.css')}}" rel="stylesheet">
    <script src="{{asset('/js/classie.js')}}" type="text/javascript"></script>
    <div class="container" style="padding-left: 80px;">
        <div class="media question">
            <div style="text-align: center" class="media-left">

                <a href="{{url('user/'.$question->asker_id)}}">

                    @if($question->asker->profile_picture)
                        <img class="media-object" src="{{asset($question->asker->profile_picture)}}" alt="...">
                    @else
                        <img class="media-object" src="{{asset('art/default_pp.png')}}" alt="...">
                    @endif
                </a>
                @if(Auth::user())
                    <a class="vote" title="upvote" style="color:green;"><span class="glyphicon glyphicon-thumbs-up"></span></a>
                @endif
                @if($question->votes > 0)
                    <span style="color:green;">{{$question->votes}} </span>
                @elseif($question->votes == 0)
                    <span style="">{{$question->votes}} </span>
                @else
                    <span style="color:red;">{{$question->votes}} </span>
                @endif
                @if(Auth::user())
                    <a class="vote" title="downvote"  style="color:red"><span class="glyphicon glyphicon-thumbs-down"></span></a>
                @endif
            </div>
            <div class="media-body">
                @if(Auth::user() && (Auth::user()->id == $question->asker_id || Auth::user()->role >= 1))
                <div class="delete_question pull-right">
                    <a onclick="return confirm('Are you sure?');" title="Delete question" class="btn btn-warning" href="{{url('delete_question/'.$question->id)}}">X</a>
                </div>
                @endif
                <a href="{{url('user/'.$question->asker_id)}}"><h3>{{$question->asker->first_name.' '.$question->asker->last_name}}</h3></a>
                <div class="question_text">
                    {{$question->question}}
                </div>
                <p style="font-weight: bold; font-style: italic; ">{{ date("F j, Y, g:i a",strtotime($question->created_at)) }} </p>
            </div>

        </div>
        <h2 style="">{{count($question->answers()->get())}} Answer(s)</h2>
        <form class="navbar-form" action="">
            <div class="form-group">
                <label class="form-label">Order by: </label>
                <select name="sort" class="form-control">
                    <option value="votes">Votes</option>
                    <option value="oldest">Oldest</option>
                    <option value="latest">Latest</option>
                </select>
                <input type="submit" class="btn btn-default" value="Sort">
            </div>
        </form>
        <div class="answers">

            @foreach($answers as $answer)
                <div class="media answer">
                    <div style="text-align: center" class="media-left">

                        <a href="{{url('user/'.$answer->responder_id)}}">

                            @if($answer->responder->profile_picture)
                                <img class="media-object" src="{{asset($answer->responder->profile_picture)}}" alt="...">
                            @else
                                <img class="media-object" src="{{asset('art/default_pp.png')}}" alt="...">
                            @endif
                        </a>
                        @if(Auth::user())
                            <a class="upvote_answer vote" value="{{$answer->id}}" title="upvote" style="color:green;"><span class="glyphicon glyphicon-thumbs-up"></span></a>
                        @endif
                        @if($answer->votes > 0)
                            <span class="answer_votes" style="color:green; font-size:18px;">{{$answer->votes}} </span>
                        @elseif($answer->votes == 0)
                            <span class="answer_votes" style="">{{$answer->votes}} </span>
                        @else
                            <span class="answer_votes" style="color:red;">{{$answer->votes}} </span>
                        @endif
                        @if(Auth::user())
                            <a class="downvote_answer vote" value="{{$answer->id}}" title="downvote" style="color:red"><span class="glyphicon glyphicon-thumbs-down"></span></a>
                        @endif
                    </div>
                    <div class="media-body">
                        @if(Auth::user() && (Auth::user()->id == $answer->responder_id || Auth::user()->role >= 1))
                        <div class="delete_answer pull-right">
                            <a onclick="return confirm('Are you sure?');" title="Delete answer" class="btn btn-warning" href="{{url('delete_answer/'.$answer->id)}}">X</a>
                        </div>
                        @endif
                        <h3>{{$answer->responder->first_name.' '.$answer->responder->last_name}}</h3>
                        <div class="answer_text">
                            {{$answer->answer}}
                        </div>
                        <p style="font-weight: bold; font-style: italic; ">{{ date("F j, Y, g:i a",strtotime($answer->created_at)) }} </p>
                    </div>

                </div>
            @endforeach
        </div>
        @if(Auth::user())
        <form id="post_answer_form" action="" method="POST">
            {{csrf_field()}}
            <div class="form-group">
                <label for="post_answer_text">Post an answer:</label>
                <textarea required class="form-control" id="post_answer_text" name="answer" placeholder="Type your answer here"></textarea>
                <input type="submit" value="Post Answer" class="btn btn-default pull-right" id="post_answer_submit">
            </div>
        </form>
        @else
            <div class="">You must be logged in to be able to answer. <a href="{{url('/login')}}">Login here.</a></div>
        @endif
    </div>



    <style>
        .question
        {
            width: 80%;
            /*min-width: 200px;*/
            margin-bottom: 50px;
        }
        .question img
        {
            width: 70px;
            height: 70px;
            border-radius: 100px;
            margin-bottom: 10px;
        }
        .question h3
        {
            /*width: 100%;*/
            font-size: 20px;
            margin-top: 2px;
            color: #621708;
            /*font-weight: bold;*/
        }

        .question .question_text
        {
            font-size: 22px;
        }

        .answer
        {
            background-color:  #F9E2C7;
            padding: 15px;
            margin-left: 80px;
            width: 60%;
            /*min-width: 200px;*/
            margin-bottom: 10px;
        }
        .answer img
        {
            width: 50px;
            height: 50px;
            border-radius: 100px;
            margin-bottom: 10px;
        }
        .answer h3
        {
            /*width: 100%;*/
            font-size: 18px;
            margin-top: 2px;
            color: #621708;
            /*font-weight: bold;*/
        }

        .answer .answer_text
        {
            font-size: 15px;
        }
        
        
        .vote
        {
            cursor: pointer;
        }

        #post_answer_form
        {
            width: 60%;
            margin-left: 90px;
            margin-top: 50px;
        }
        #post_answer_form textarea
        {
            resize: none;
            height:150px;
            font-size: 18px;
        }
        #post_answer_form #post_answer_submit
        {
            background-color: #FFE9CF;
            border: 1px solid #CCB69C;
            margin-top: 10px;
        }
        #post_answer_form #post_answer_submit:focus
        {
            background-color: #CCB69C;
            /*border: 1px solid #CCB69C !important;*/

        }



    </style>

    <script>
        $(document).ready(function(){
            if($('#post_answer_text').val().trim().length == 0)
                $('#post_answer_submit').attr('disabled',true);
            else
                $('#post_answer_submit').attr('disabled',false);
        });
        $('.downvote_answer').click(function()
        {
            var answer_id = $(this).attr('value');
            var type = 1;
            var answer = $(this);
            $.ajax({
                'url' : "{{url('')}}/vote/"+answer_id+"/"+type,
                success: function(data){
                    answer.parent().find('.answer_votes').html(data);
                }
            });
        });
        $('.upvote_answer').click(function()
        {
            var answer_id = $(this).attr('value');
            var type = 0;
            var answer = $(this);
            $.ajax({
                'url' : "{{url('')}}/vote/"+answer_id+"/"+type,
                success: function(data){
                    answer.parent().find('.answer_votes').html(data);
                }
            });
        });

        $('#post_answer_text').keyup(function()
        {
            if($(this).val().trim().length == 0)
                $('#post_answer_submit').attr('disabled',true);
            else
                $('#post_answer_submit').attr('disabled',false);

        });
    </script>
@endsection