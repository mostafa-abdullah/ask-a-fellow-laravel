<?php
$order = 'latest';
if(isset($_GET['sort']))
    $order = $_GET['sort'];
$allowed = ['votes','oldest','latest','answers'];
if(!in_array($order,$allowed))
    $order = 'latest';


$questions_ordered = array();
if($order == 'votes')
    $questions_ordered = $questions->orderBy('votes','desc')->orderBy('created_at','desc')->get();
elseif($order == 'oldest')
    $questions_ordered = $questions->orderBy('created_at','asc')->get();
elseif($order == 'latest')
    $questions_ordered = $questions->orderBy('created_at','desc')->get();
else if($order == 'answers')
    $questions_ordered =$questions->orderByRaw("(SELECT COUNT(*) FROM answers WHERE question_id = questions.id) DESC    ")->orderBy('created_at','desc')->get();
//die($questions_ordered);



?>

@extends('layouts.app')
@section('content')
    <div class="container" style="width:100%;">
        <div class="questions">
            <h3 style="margin-left: 50px">Showing {{count($questions->get())}} out of {{$num_questions}} Question(s).</h3>

            <div id="filtration_form">
                <form class="" action="">
                    <div class="form-group">
                        <label class="form-label">Order by: </label>
                        <select name="sort" class="form-control">
                            <option {{isset($_GET['sort']) && $_GET['sort'] == 'votes'?'selected':''}} value="votes">Votes</option>
                            <option {{isset($_GET['sort']) && $_GET['sort'] == 'answers'?'selected':''}} value="answers">Number of answers</option>
                            <option {{isset($_GET['sort']) && $_GET['sort'] == 'oldest'?'selected':''}} value="oldest">Oldest</option>
                            <option {{isset($_GET['sort']) && $_GET['sort'] == 'latest'?'selected':''}} value="latest">Latest</option>
                        </select>
                        <label class="form-label">Questions per page: </label>
                        <input class="form-control" type="number" name="take" value="{{isset($_GET['take'])?$_GET['take']:10}}">
                        <input type="submit" class="btn btn-default" value="Update">
                    </div>
                </form>
            </div>




            @foreach($questions_ordered as $question)
               <div href="{{url('answers/'.$question->id)}}" class="media question">
                    <div style="text-align: center" class="media-left">

                        <a href="{{url('user/'.$question->asker_id)}}">

                            @if($question->asker->profile_picture)
                                <img class="media-object" src="{{asset($question->asker->profile_picture)}}" alt="...">
                            @else
                                <img class="media-object" src="{{asset('art/default_pp.png')}}" alt="...">
                            @endif
                        </a>
                        @if(Auth::user())
                            <a class="upvote_question vote" value="{{$question->id}}" title="upvote" style="color:green;"><span class="glyphicon glyphicon-thumbs-up"></span></a>
                        @endif
                        @if($question->votes > 0)
                            <span class="question_votes" style="color:green;">{{$question->votes}} </span>
                        @elseif($question->votes == 0)
                            <span class="question_votes" style="">{{$question->votes}} </span>
                        @else
                            <span class="question_votes" style="color:red;">{{$question->votes}} </span>
                        @endif
                        @if(Auth::user())
                            <a class="downvote_question vote" value="{{$question->id}}" title="downvote" style="color:red"><span class="glyphicon glyphicon-thumbs-down"></span></a>
                        @endif
                    </div>
                    <div class="media-body" style="cursor: pointer;">
                        @if(Auth::user() && (Auth::user()->id == $question->asker_id || Auth::user()->role >= 1))
                            <div class="delete_question pull-right">
                                <a onclick="return confirm('Are you sure?');" title="Delete answer" class="btn btn-warning" href="{{url('delete_answer/'.$question->id)}}">X</a>
                            </div>
                        @endif
                        <h3>{{$question->asker->first_name.' '.$question->asker->last_name}}</h3>
                        <div class="question_text">
                            {{$question->question}}
                        </div>
                        <p style="font-weight: bold; font-style: italic; ">{{ date("F j, Y, g:i a",strtotime($question->created_at)) }} </p>
                    </div>


                </div>

            @endforeach
            <form id="post_question_form" action="" method="POST">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="post_answer_text">Ask a question:</label>
                    <textarea required class="form-control" id="post_question_text" name="question" placeholder="Type your question here"></textarea>
                    <input type="submit" value="Post Question" class="btn btn-default pull-right" id="post_question_submit">
                </div>
            </form>
        </div>
    </div>



    <style>
        #filtration_form
        {
            width: 20%;
            float:right;
            /*display: inline-block;*/

        }
        .question
        {
            background-color:  #FFF5E9;
            padding: 15px;
            margin-left: 80px;
            width: 70%;
            /*min-width: 200px;*/
            margin-bottom: 10px;
        }
        .question img
        {
            width: 50px;
            height: 50px;
            border-radius: 100px;
            margin-bottom: 10px;
        }
        .question h3
        {
            /*width: 100%;*/
            font-size: 18px;
            margin-top: 2px;
            color: #621708;
            /*font-weight: bold;*/
        }

        .question .question_text
        {
            font-size: 15px;
        }

        .vote
        {
            cursor: pointer;
        }

        .question .media-body
        {
            cursor: pointer;
        }

        .question:hover
        {
            background-color:  #F5E0C2;
        }


        #post_question_form
        {
            width: 60%;
            margin-left: 90px;
            margin-top: 50px;
        }
        #post_question_form textarea
        {
            resize: none;
            height:150px;
            font-size: 18px;
        }
        #post_question_form #post_question_submit
        {
            background-color: #FFE9CF;
            border: 1px solid #CCB69C;
            margin-top: 10px;
        }
        #post_question_form #post_question_submit:focus
        {
            background-color: #CCB69C;
            /*border: 1px solid #CCB69C !important;*/

        }

    </style>

    <script>
        $('.question_text').click(function(){
           window.location.href = $(this).parent().parent().attr('href');
        });

        $('.upvote_question').click(function(){
            var question_id = $(this).attr('value');
            var type = 0;
            var question = $(this);
            $.ajax({
                'url' : "{{url('')}}/vote/question/"+question_id+"/"+type,
                success: function(data){
                    question.parent().find('.question_votes').html(data);
                }
            });
        });

        $('.downvote_question').click(function(){
            var question_id = $(this).attr('value');
            var type = 1;
            var question = $(this);
            $.ajax({
                'url' : "{{url('')}}/vote/question/"+question_id+"/"+type,
                success: function(data){
                    question.parent().find('.question_votes').html(data);
                }
            });
        });
    </script>

@endsection