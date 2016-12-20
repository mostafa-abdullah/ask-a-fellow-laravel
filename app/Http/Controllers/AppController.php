<?php

namespace App\Http\Controllers;



use App\AnswerReport;
use App\QuestionReport;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Major;
use App\Course;
use App\Question;
use App\Answer;
use App\Notification;
use App\Feedback;
use Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;


class AppController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['only' => [
            'post_question',
            'post_answer',
            'delete_question',
            'delete_answer',
            'view_notifications',
            'subscribe_to_courses',
            'subscription_page',
            'post_question_all'
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
        $count_questions = count($course->questions()->get());


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
            $questions_ordered =$questions->orderByRaw("(SELECT COUNT(*) FROM answers WHERE question_id = questions.id) DESC")->orderBy('created_at','desc')->get();
        return view('questions.questions',compact(['questions_ordered','count_questions']));

    }


    public function list_questions_all($major_id, $semester)
    {
        $major = Major::find($major_id);
        $courses = $major->courses()->where('semester','=',$semester)->get(['courses.id','courses.course_name']);
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
        $questions = Question::whereIn('course_id',$ids);
        $all = true;
        $count_questions = count($questions->get());
        $questions = $questions->skip($page * $take)->take($take);

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
            $questions_ordered =$questions->orderByRaw("(SELECT COUNT(*) FROM answers WHERE question_id = questions.id) DESC")->orderBy('created_at','desc')->get();
        return view('questions.questions',compact(['questions_ordered','all','count_questions','courses']));
    }


    public function post_question_all(Request $request,$major, $semester)
    {
        $this->validate($request,[
            'question' => 'required',
            'course' => 'required|exists:courses,id'
        ]);
        $this->post_question($request,$request->course);
        return redirect('/browse/'.$major.'/'.$semester);
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
        if(Auth::user() && (Auth::user()->role > 0 ||  Auth::user()->id == $question->asker_id))
            $question->delete();
        return redirect(url('browse/'.$question->course_id));
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
        if(Auth::user() && (Auth::user()->role > 0 || Auth::user()->id == $answer->responder_id))
            $answer->delete();
        return redirect(url('answers/'.$answer->question_id));
    }








    public function view_notifications()
    {
        $user = Auth::user();
        $notifications = $user->notifications;

        return view('user.notifications',compact('notifications'));

    }


    public function subscription_page()
    {
        $majors = Major::all();
        $courses = Auth::user()->subscribed_courses()->get(['courses.id']);
        $subscribed_courses = array();
        foreach($courses as $course)
            $subscribed_courses[] = $course->id;
        return view('user.subscriptions',compact(['majors','subscribed_courses']));
    }

    public function subscribe_to_courses(Request $request)
    {
        $this->validate($request,[
            'course.*' => 'numeric|exists:courses,id'
        ]);

        Auth::user()->subscribed_courses()->detach();
        if($request->course)
            Auth::user()->subscribe_to_courses(array_unique($request->course));

        return redirect('/home');
    }


    public function send_feedback(Request $request)
    {
        $this->validate($request,[
            'email' => 'email',
            'feedback' => 'required'
        ]);
        $feedback = new Feedback;
        $feedback->name = $request->name;
        $feedback->email = $request->email;
        $feedback->feedback = $request->feedback;
        $feedback->save();
        Session::flash('feedback','Feedback submitted successfully');
        return Redirect::back();
    }


}


