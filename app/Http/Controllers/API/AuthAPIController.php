<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

use Tymon\JWTAuth\Token;
use App\User;
use JWTAuth;
use JWTFactory;
use Response;
use Validator;
use Mail;
use Auth;


class AuthAPIController extends Controller
{
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }
    
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $confirmation_code = str_random(32);
        Mail::send('auth.emails.verify', ['confirmation_code' => $confirmation_code, 'name' => $data['first_name']], function($message) use ($data) {
            $message->to($data['email'], $data['first_name'])
                ->subject('Verify your email address');
        });

        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'confirmation_code' => $confirmation_code,
            'confirmed' => false
        ]);
    }

    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails())
            return response()->json($validator->errors(), 302);
        $this->create($request->all());

        return response()->json(['message' => 'Thank you for registering. Kindly go to your email and follow the link to verify your account'], 200);
    }

    public function verify($token)
    {
        $user = User::where('confirmation_code','=',$token)->first();
        if($user){
            $user->confirmed = true;
            $user->save();
            return response()->json(['message' => 'Your email is now verified'], 200);
        }else{
            return response()->json(['message' => 'invalid activation code'], 200);
        }

    }
    /**
     * Logout for a User
     */

    public function logout(Request $request)
    {
        try
        {
            if($request->header('x-access-token'))
                JWTAuth::setToken(new Token($request->header('x-access-token')))->invalidate();
        }
        catch(TokenInvalidException $e)
        {
            return response()->json(['message' => 'invalid token'], 200);
        }
        return response()->json(['message' => 'Logged out.'], 200);
    }
}
