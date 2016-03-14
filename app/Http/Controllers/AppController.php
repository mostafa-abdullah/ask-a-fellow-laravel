<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Major;

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
}
