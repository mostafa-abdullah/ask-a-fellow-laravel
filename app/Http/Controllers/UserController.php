<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests;
use Auth;
use App\Major;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth',['only'=>[
            'updateInfoPage'
        ]]);
    }

    public function show($id)
    {
        $user = User::find($id);
        if(!$user)
            return 'Ooops! User doesn\'t exit';
        return view('user.questions',compact(['user']));
    }


    public function showProfileAnswers($id)
    {
        $user = User::find($id);
        if(!$user)
            return 'Ooops! User doesn\'t exit';
        return view('user.answers',compact(['user']));
    }


    public function updateInfoPage()
    {
        $user = Auth::user();
        if(!$user)
            return 'Ooops! Not authorized';
        $majors = Major::all();
        return view('user.update',compact(['user','majors']));
    }


    public function updateInfo(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'alpha|required',
            'last_name' => 'alpha|required',
            'major' => 'numeric|exists:majors,id',
            'semester' => 'numeric|min:0|max:10',
            'profile_picture' => 'image|max:1000'

        ]);


        $user = Auth::user();

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->semester = $request->semester;
        if($request->major)
            $user->major_id = $request->major;
        else
            $user->major_id = null;
        $user->bio = $request->bio;

        if($request->file('profile_picture'))
        {

            //change profile picture
            if($user->profile_picture)
                unlink('../public'.Auth::user()->profile_picture);
            $file = $request->file('profile_picture');
            $photoname = uniqid();

            $file_name = $photoname.'.'.$file->guessClientExtension();

            //resize here
            $file->move('../public/art/pp',$file_name);
            $user->profile_picture = '/art/pp/' . $photoname . '.'.$file->guessClientExtension();
        }

        $user->save();




        Session::flash('updated','Info updated successfully!');
        return redirect(url('/user/'.$user->id));
    }


}
