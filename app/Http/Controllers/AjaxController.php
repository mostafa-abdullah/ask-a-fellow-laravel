<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Http\Requests;
use App\Major;
use App\Answer;
use Auth;
use App\AnswerVote;
use App\Question;
use App\QuestionVote;

class AjaxController extends Controller
{
    public function __construct(){
//        $this->middleware('ajax');
        $this->middleware('auth', ['only' => [
            'vote_answer',
            'vote_question'
        ]]);
    }


    public function getCourses($major, $semester)
    {
//            return 'x';
        $major = Major::find($major);
        $courses = $major->courses()->where('semester','=',$semester)->get();
        return view('browse.courses_listing',compact(['courses']));
    }

    public function vote_answer($answer_id, $type)
    {
        $user = Auth::user();

        if($type == 0 && count($user->upvotesOnAnswer($answer_id)))
            return 'Cannot upvote twice';
        if($type == 1 && count($user->downvotesOnAnswer($answer_id)))
            return 'Cannot downvote twice';
        if($type == 0 && count($user->downvotesOnAnswer($answer_id))) {
            $vote = AnswerVote::where('user_id','=',Auth::user()->id)->where('answer_id','=',$answer_id)->first();
            $vote->delete();
        }
        else if($type == 1 && count($user->upvotesOnAnswer($answer_id))) {
            $vote = AnswerVote::where('user_id','=',Auth::user()->id)->where('answer_id','=',$answer_id)->first();
            $vote->delete();
        }
        else
            $user->vote_on_answer($answer_id, $type);


        $votes = Answer::find($answer_id)->votes;
        $color = 'black';
        if($votes>0)
            $color = 'green';
        elseif($votes <0)
            $color = 'red';
        return '<span style="color:'.$color.'"">'.$votes.'</span>';
    }

    public function vote_question($question_id, $type)
    {
        $user = Auth::user();

        if($type == 0 && count($user->upvotesOnQuestion($question_id)))
            return 'Cannot upvote twice';
        if($type == 1 && count($user->downvotesOnQuestion($question_id)))
            return 'Cannot downvote twice';
        if($type == 0 && count($user->downvotesOnQuestion($question_id))) {
            $vote = QuestionVote::where('user_id','=',Auth::user()->id)->where('question_id','=',$question_id)->first();
            $vote->delete();
        }
        else if($type == 1 && count($user->upvotesOnQuestion($question_id))) {
            $vote = QuestionVote::where('user_id','=',Auth::user()->id)->where('question_id','=',$question_id)->first();
            $vote->delete();
        }
        else
            $user->vote_on_question($question_id, $type);


        $votes = Question::find($question_id)->votes;
        $color = 'black';
        if($votes>0)
            $color = 'green';
        elseif($votes <0)
            $color = 'red';
        return '<span style="color:'.$color.'"">'.$votes.'</span>';
    }
}
