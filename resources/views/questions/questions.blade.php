@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="questions">
            <h3 style="margin-left: 50px">Showing {{count($questions->get())}} out of {{$num_questions}} Question(s).</h3>
            @foreach($questions->get() as $question)
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
                            <a class="upvote_question vote" value="{{$question->id}}" title="upvote" style="color:green;"><span class="glyphicon glyphicon-thumbs-up"></span></a>
                        @endif
                        @if($question->votes > 0)
                            <span class="answer_votes" style="color:green; font-size:18px;">{{$question->votes}} </span>
                        @elseif($question->votes == 0)
                            <span class="answer_votes" style="">{{$question->votes}} </span>
                        @else
                            <span class="answer_votes" style="color:red;">{{$question->votes}} </span>
                        @endif
                        @if(Auth::user())
                            <a class="downvote_question vote" value="{{$question->id}}" title="downvote" style="color:red"><span class="glyphicon glyphicon-thumbs-down"></span></a>
                        @endif
                    </div>
                    <div class="media-body">
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
        </div>
    </div>



    <style>
        .question
        {
            background-color:  #F9E2C7;
            padding: 15px;
            margin-left: 80px;
            width: 60%;
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

    </style>

@endsection