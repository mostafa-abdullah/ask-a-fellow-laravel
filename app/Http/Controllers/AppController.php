<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Major;
use App\Course;
use App\Question;

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
}
