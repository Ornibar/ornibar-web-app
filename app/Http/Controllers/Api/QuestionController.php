<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController;
use Symfony\Component\HttpKernel\Exception\HttpException;


class QuestionController extends BaseController
{


      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function questionsWithResponses(Request $request)
    {
        $validator = $request->validate([
            'numberQuestions' => 'required|integer',
        ]);

        try {
            $questions = DB::table('questions')
            ->join('responses', 'questions.id', '=', 'responses.question_id')
            ->where('questions.is_active', "1")
            ->where('responses.is_active', '1')
            ->select('questions.id', 'questions.title', 'questions.file', DB::raw('SUM(responses.is_active) AS total_responses'))
            ->limit($validator['numberQuestions'])
            ->groupBy("questions.id")
            // ->sum('responses.is_active')
            ->having('total_responses', '>', 1)
            ->get();

            foreach($questions as $question) {
                $file = json_decode($question->file);
                $question->file = $file;
            }

            foreach($questions as &$question) {
                $responses = DB::table('responses')
                ->select('id', 'name', 'question_id')
                ->where('responses.is_active', "1")
                ->where('responses.question_id', $question->id)
                ->get();
                
                $question->responses = $responses;
            }
            return $this->sendResponse(["questions" => $questions], 'Fetching question succesfully');
        } catch(Exception $e) {
            return $this->sendError('Unauthorised.', ['error'=>$e], 403);
        }



    }
}