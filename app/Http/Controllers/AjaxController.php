<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Major;

class AjaxController extends Controller
{
    public function _construct(){
        $this->middleware('ajax');
    }


    public function getCourses($major, $semester)
    {
//            return 'x';
        $major = Major::find($major);
        $courses = $major->courses()->where('semester','=',$semester)->get();
        return view('browse.courses_listing',compact(['courses']));
    }
}
