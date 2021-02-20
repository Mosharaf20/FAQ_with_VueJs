<?php

namespace App\Http\Controllers;

use App\Answer;
use Illuminate\Http\Request;

class AnswerAcceptController extends Controller
{
    public function __invoke(Answer $answer)
    {
        $answer->question->acceptBestAnswer($answer);

        if(request()->expectsJson()){
            return response()->json([
                'message'=>'This Answer Choose for best Answer'
            ]);
        }
        return back();
    }
}
