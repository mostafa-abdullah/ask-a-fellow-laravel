<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests;

class UserController extends Controller
{
    public function show($id)
    {
        $user = User::find($id);
        if(!$user)
            return 'Ooops! User doesn\'t exit';
        return view('user.profile',compact(['user']));
    }
}
