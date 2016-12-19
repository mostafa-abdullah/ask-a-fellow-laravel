<?php
namespace App\Http\Controllers\API;

class UserAPIController extends controller
{
    public function __construct()
    {
        $this->middleware('auth', ['only' => [
        ]]);

    }

      /**
       * getUser is used to get all user's profile data
       */

    public function getUser($userID){
        // get specified user by id
        $user = User::find($userID);

        // check if the user is valid
        if(!$user)
          // create an error json object to be send in the http response
          return response()->json(
              'status'=> 404,
              'message'=> 'Bad Request',
              "errors"=>[
                  {
                    'resourse' => 'users',
                    'message'=> 'Invalid User ID'
                  }
              ]

            ,404);


          // the user is valid
          




    }

}
