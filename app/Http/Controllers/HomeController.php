<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user  = Auth::user();
        $questions = $user->home_questions();

        $count_questions = count($questions->get());

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
        $questions = $questions->orderBy('created_at','desc')->skip($page * $take)->take($take)->get();

        return view('home',compact(['questions','count_questions']));
    }
}
