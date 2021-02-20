<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Http\Requests\AnswerRequest;
use App\Question;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    public function index(Question $question)
    {
        return $question->answers()->with('user')->latest()->simplePaginate(3);


    }

    public function store(Request $request,Question $question)
    {
        $answer = $question->answers()->create(
            request()->validate(['body'=>'required'])
            +['user_id'=>Auth::id()]
        );

        if(request()->expectsJson()){
            return response()->json([
                'message'=>'Answer has Been Created Successfully',
                'answer'=>$answer->load('user'),
            ]);
        }

        return redirect()->back()->with('success','Answer has been created successfully');
    }

    public function edit(Question $question,Answer $answer)
    {
        $this->authorize('update',$answer);

        return view('answers.edit',compact('question','answer'));
    }


    public function update(Request $request,Question $question, Answer $answer)
    {
        $this->authorize('update',$answer);

        $answer->update(request()->validate(['body'=>'required']));

        if(request()->expectsJson()){
            return response()->json([
               'body'=>$answer->body,
                'message'=>'Answer has been updated successfully'
            ]);
        }

        return redirect()->route('questions.show',$question->slug)->with('Answer has been updated successfully');
    }

    public function destroy(Question $question,Answer $answer)
    {
        $this->authorize('delete',$answer);

       $answer->delete();

        if(request()->expectsJson()){
            return response()->json([
                'success'=>'Answer has been deleted successfully'
            ]);
        }

       return redirect()->back()->with('success','Answer has been deleted successfully');   }
}
