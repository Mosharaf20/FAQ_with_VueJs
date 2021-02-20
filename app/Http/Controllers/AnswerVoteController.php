<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerVoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(Answer $answer,Request $request)
    {
        $user = Auth::user();
        $answer = $user->voteAnswer($answer,$request->votes);

        if(request()->expectsJson()){
            return response()->json([
                'message'=> 'Voted has been added Successfully',
                'vote_counts' => $answer
            ]);
        }

        return back();
    }
}
