<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionVoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(Question $question,Request $request)
    {

        $user = Auth::user();
        $question = $user->voteQuestion($question,$request->votes);

        if(request()->expectsJson()){
            return response()->json([
                'message'=> 'Voted has been added Successfully',
                'vote_counts' => $question
            ]);
        }

        return back();
    }
}
