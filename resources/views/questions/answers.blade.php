@extends('layouts.app')
@section('content')
    <div class="container" style="padding-left: 80px;">
        <div class="media question">
            <div style="text-align: center" class="media-left">

                <a href="#">

                    @if($question->asker->profile_picture)
                        <img class="media-object" src="{{asset($question->asker->profile_picture)}}" alt="...">
                    @else
                        <img class="media-object" src="{{asset('art/default_pp.png')}}" alt="...">
                    @endif
                </a>
                @if(Auth::user())
                    <a title="upvote" style="color:green;"><span class="glyphicon glyphicon-thumbs-up"></span></a>
                @endif
                @if($question->votes > 0)
                    <span style="color:green;">{{$question->votes}} </span>
                @elseif($question->votes == 0)
                    <span style="">{{$question->votes}} </span>
                @else
                    <span style="color:red;">{{$question->votes}} </span>
                @endif
                @if(Auth::user())
                    <a title="downvote"  style="color:red"><span class="glyphicon glyphicon-thumbs-down"></span></a>
                @endif
            </div>
            <div class="media-body">
                <h3>{{$question->asker->first_name.' '.$question->asker->last_name}}</h3>
                <div class="question_text">
                    {{$question->question}}
                </div>
                <p style="font-weight: bold; font-style: italic; ">{{ date("F j, Y, g:i a",strtotime($question->created_at)) }} </p>
            </div>

        </div>
        <h2>{{count($question->answers()->get())}} Answer(s)</h2>
        <div class="answers">
            @foreach($question->answers()->get() as $answer)
                <div class="media answer">
                    <div style="text-align: center" class="media-left">

                        <a href="#">

                            @if($answer->responder->profile_picture)
                                <img class="media-object" src="{{asset($answer->responder->profile_picture)}}" alt="...">
                            @else
                                <img class="media-object" src="{{asset('art/default_pp.png')}}" alt="...">
                            @endif
                        </a>
                        @if(Auth::user())
                            <a class="upvote_answer" value="{{$answer->id}}" title="upvote" style="color:green;"><span class="glyphicon glyphicon-thumbs-up"></span></a>
                        @endif
                        @if($question->votes > 0)
                            <span class="answer_votes" style="color:green;">{{$answer->votes}} </span>
                        @elseif($question->votes == 0)
                            <span class="answer_votes" style="">{{$answer->votes}} </span>
                        @else
                            <span class="answer_votes" style="color:red;">{{$answer->votes}} </span>
                        @endif
                        @if(Auth::user())
                            <a class="downvote_answer" value="{{$answer->id}}" title="downvote" href="#" style="color:red"><span class="glyphicon glyphicon-thumbs-down"></span></a>
                        @endif
                    </div>
                    <div class="media-body">
                        <h3>{{$answer->responder->first_name.' '.$answer->responder->last_name}}</h3>
                        <div class="answer_text">
                            {{$answer->answer}}
                        </div>
                        <p style="font-weight: bold; font-style: italic; ">{{ date("F j, Y, g:i a",strtotime($answer->created_at)) }} </p>
                    </div>

                </div>
            @endforeach
        </div>
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

    </style>

    <script>
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
    </script>
@endsection