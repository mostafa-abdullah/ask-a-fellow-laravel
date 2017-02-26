<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers;
use App\Http\Requests;
use App\Question;
use Auth;


/**
 * Class QuestionAPIController
 * @package App\Http\Controllers\API
 */
class QuestionAPIController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['only' => [
        ]]);

    }

    /**
     * returns a json object of the header of the question (all of its info)
     */

    /**
     * @param $question_id
     * @return \Illuminate\Http\JsonResponse
     */

    public function view_question_header($question_id)
    {
        $Question = Question::find($question_id);
        if(!$Question){
            return response()->json([
                'error' => [
                    'message' => 'Question requested not found'
                ]

            ], 404);
        }

        $asker = $Question->asker();

        return response()->json([
            'data' => [
                'question' => $Question['question'],
                'creation' => $Question['created_at'],
                'update' => $Question['updated_at'],
                'votes' => $Question['votes'],
                'asker_fname' => $asker['first_name'],
                'asker_lname' => $asker['last_name']
            ]

        ], 200);

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
            foreach ($answers as $answer) {
               $answer['responder'] = $answer->responder;
            }
            $returnData['data'] = $answers;
        }


        return response()->json($returnData);
    }
}
