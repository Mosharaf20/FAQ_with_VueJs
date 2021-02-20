<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Question $question)
    {
        $question->favourites()->toggle(auth()->user()->id);

        if(request()->expectsJson()){
            return response()->json([
                'message'=>'Favourite is updated successfully'
            ]);
        }

        return back();
    }

    public function destroy(Question $question)
    {
        $question->favourites()->detach(auth()->user()->id);

        return back();
    }
}
