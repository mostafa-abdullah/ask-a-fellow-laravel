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
    public function __construct()
    {
        $this->middleware('auth', ['only' => [
            'post_question',
            'post_answer',
            'delete_question',
            'delete_answer'
        ]]);

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

        if(isset($_GET['page']))
            $page = $_GET['page'];
        else
            $page = 0;
        if(isset($_GET['take']))
            $take = $_GET['take'];
        else
            $take = 10;


        if($take <= 0)
            $take = 10;
        if($page <= 0)
            $page = 0;


        $questions = $course->questions()->skip($page * $take)->take($take);
        $num_questions = count($course->questions()->get());
        return view('questions.questions',compact(['questions','num_questions']));

    }


    public function list_questions_all($major_id, $semester)
    {
        $major = Major::find($major_id);
        $courses = $major->courses()->where('semester','=',$semester)->get(['courses.id']);
        $ids = array();
        foreach($courses as $course)
            $ids[] = $course->id;

        if(isset($_GET['page']))
            $page = $_GET['page'];
        else
            $page = 0;
        if(isset($_GET['take']))
            $take = $_GET['take'];
        else
            $take = 10;
        if($take <= 0)
            $take = 10;
        if($page <= 0)
            $page = 0;
        $questions = Question::whereIn('course_id',$ids)->skip($page * $take)->take($take);
        $all = true;
        $num_questions = count(Question::whereIn('course_id',$ids)->get());
        return view('questions.questions',compact(['questions','all','num_questions']));
    }


    public function post_question(Request $request, $course_id)
    {
        $this->validate($request,[
            'question' => 'required'
        ]);
        $question = new Question;
        $question->asker_id = Auth::user()->id;
        $question->question = $request->question;
        $question->course_id = $course_id;
        $question->save();
        return redirect('/browse/'.$course_id);
    }

    public function delete_question($question_id)
    {
        $question = Question::find($question_id);
        if(Auth::user() && Auth::user()->id == $question->asker_id)
            $question->delete();
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

        $asker_id = Question::find($question_id)->asker_id;
        $description = Auth::user()->first_name.' '.Auth::user()->last_name.' posted an answer to your question.';
        $link = url('/answers/'.$question_id);
        Notification::send_notification($asker_id,$description,$link);
        return redirect(url('/answers/'.$question_id));
    }


    public function delete_answer($answer_id)
    {
        $answer = Answer::find($answer_id)->find($answer_id);
        if(Auth::user() && Auth::user()->id == $answer->responder_id)
            $answer->delete();
        return redirect(url('answers/'.$answer->question_id));
    }





    public function view_notifications()
    {
        $user = Auth::user();
        $notifications = $user->notifications;
        return $notifications;
    }


}


