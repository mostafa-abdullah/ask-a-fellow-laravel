<?php

namespace App\Http\Controllers;

use App\Course;
use App\Major;
use App\Question;
use App\QuestionVote;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['only' => [
            'vote_question', 'post_question','home'
        ]]);
    }

    public function browse()
    {
        $majors = Major::all();
        $semesters = [1, 2, 3, 4, 5, 6, 7, 8, 9];
        return ['majors' => $majors, 'semesters' => $semesters];
    }

    public function getCourses($major, $semester)
    {
        $major = Major::find($major);
        $courses = $major->courses()->where('semester', '=', $semester)->get();
        return ['courses' => $courses];
    }

    public function list_questions($course_id)
    {

        $course = Course::find($course_id);
        //sort questions
        if (!$course)
            return ['error' => 'course not found'];
        $new_questions = array();

        $questions = $course->questions()->latest()->paginate(10);
        foreach ($questions as $question) {
            $question['asker'] = $question->asker()->get();
            $question['count_answers'] = $question->answers()->get()->count();
        }
        $questions->setPath('api/v1/');
        $count_questions = count($course->questions()->get());

        return ['questions' => $questions, 'count_questions' => $count_questions];
    }


    public function vote_question($question_id, $type)
    {
        $user = Auth::user();
        if (!$user) {
            return ['state' => 'error', 'error' => true];
        }

        if ($type == 0 && count($user->upvotesOnQuestion($question_id)))
            return ['state' => 'cannot up vote twice', 'error' => true];
        if ($type == 1 && count($user->downvotesOnQuestion($question_id)))
            return ['state' => 'cannot down vote twice', 'error' => true];
        if ($type == 0 && count($user->downvotesOnQuestion($question_id))) {
            $vote = QuestionVote::where('user_id', '=', Auth::user()->id)->where('question_id', '=', $question_id)->first();
            $vote->delete();
        } else if ($type == 1 && count($user->upvotesOnQuestion($question_id))) {
            $vote = QuestionVote::where('user_id', '=', Auth::user()->id)->where('question_id', '=', $question_id)->first();
            $vote->delete();
        } else
            $user->vote_on_question($question_id, $type);

        $question = Question::find($question_id);
        if (Auth::user()->id != $question->asker_id) {
            //send notification
            $asker_id = $question->asker_id;
            $action = ($type == 0) ? ' upvoted' : ' downvoted';
            $description = Auth::user()->first_name . ' ' . Auth::user()->last_name . $action . ' your question.';
            $link = url('/answers/' . $question_id);
            Notification::send_notification($asker_id, $description, $link);

        }

        $votes = Question::find($question_id)->votes;
        $color = 'black';
        if ($votes > 0)
            $color = 'green';
        elseif ($votes < 0)
            $color = 'red';
        return ['state' => '200 ok', 'error' => false];
    }

    public function post_question(Request $request, $course_id)
    {
        $this->validate($request, [
            'question' => 'required'
        ]);
        $question = new Question;
        $question->asker_id = Auth::user()->id;
        $question->question = $request->question;
        $question->course_id = $course_id;
        $question->save();
        return ['state' => '200 ok', 'error' => false];
    }

    public function home()
    {
        $user  = Auth::user();
        $questions = $user->home_questions();
        $count_questions = count($questions->get());
        $questions = $questions->orderBy('created_at','desc')->paginate(10);
      // dd($questions);
        foreach ($questions as $question) {
           
            $question['asker'] = $question->asker()->get();
            $question['count_answers'] = $question->answers()->get()->count();
        }


        $questions->setPath('http://localhost:8000/api/v1/');
       return $questions;
    }
}
