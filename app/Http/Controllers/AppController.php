<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Http\Requests;
use App\Major;
use App\Course;
use App\Question;
use App\Answer;
use App\Notification;
use Auth;


class AppController extends Controller
{
    public function _construct()
    {

    }

    public function browse()
    {
        $majors = Major::all();
        $semesters = [1,2,3,4,5,6,7,8,9];
        return view('browse.index',compact(['majors','semesters']));
    }


    public function list_questions($course_id)
    {
        $course = Course::find($course_id);
        //sort questions
        if(!$course)
            return 'Ooops! course not found';
        $questions = $course->questions()->get();

        return $questions;
    }



    public function inside_question($question_id)
    {

        $question = Question::find($question_id);
        if(!$question)
            return 'Ooops! question not found';
        //sort answers
        $answers = $question->answers()->get();

        return view('questions.answers',compact(['question','answers']));


    }

    public function post_answer(Request $request,$question_id)
    {
        $this->validate($request, [
            'answer' => 'required|min:5',
        ]);
        $answer = new Answer;
        $answer->answer = $request->answer;
        $answer->responder_id = Auth::user()->id;
        $answer->question_id = $question_id;
        $answer->save();

        $asker_id = Question::find($question_id)->first()->asker_id;
        $description = Auth::user()->first_name.' '.Auth::user()->last_name.' posted an answer to your question.';
        $link = url('/answers/'.$question_id);
        Notification::send_notification($asker_id,$description,$link);
        return redirect(url('/answers/'.$question_id));
    }
}
