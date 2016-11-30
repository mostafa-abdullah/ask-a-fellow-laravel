<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers;
use App\Http\Requests;
use App\Question;
use Auth;


class QuestionAPIController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['only' => [
        ]]);

    }

    /**
     *  returns a json object of the answers of a certain $question_id order by $order.
     *  $order : votes, latest, oldest.
     **/

    public function view_answers($question_id, $order)
    {

        $question = Question::find($question_id);
        $returnData = array();

        if (!$question) {
            $returnData['status'] = false;
            $returnData['message'] = 'Invalid question id.';
        } else {
            if ($order == 'oldest')
                $answers = $question->answers()->orderBy('created_at', 'asc')->get();
            elseif ($order == 'latest')
                $answers = $question->answers()->orderBy('created_at', 'desc')->get();
            else
                $answers = $question->answers()->orderBy('votes', 'desc')->orderBy('created_at', 'desc')->get();

            $returnData['status'] = true;
            $returnData['data'] = $answers;
        }


        return response()->json($returnData);
    }
}
