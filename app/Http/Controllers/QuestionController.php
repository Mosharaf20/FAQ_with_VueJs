<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequest;
use App\Question;
use http\Env\Response;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index','show');
    }

    public function index()
    {
        $questions = Question::with('user')->latest()->paginate(5);

        return view('questions.index',compact('questions'));
    }

    public function create()
    {
        return view('questions.create');
    }

    public function store(QuestionRequest $request)
    {
        \Auth::user()->questions()->create($request->all())->only('title','body');

        return redirect()->route('questions.index')->with('success','Questions has been added successfully');
    }

    public function show(Question $question)
    {
        $question->load('answers.user');
        return view('questions.show',compact('question'));
    }

    public function edit(Question $question)
    {
        $this->authorize('update',$question);

        return view('questions.edit',compact('question'));
    }

    public function update(Request $request, Question $question)
    {
        $this->authorize('update',$question);

        $data = $this->validate($request,[
           'title'=>'required','string','unique:questions'.$question->id,
           'body'=>'required',
        ]);

        $question->update($data);

        if(request()->expectsJson()){
            return response()->json([
                'message'=>'Question has been updated successfully',
                'data'=>$question
            ]);
        }

        return redirect()->route('questions.index')->with('success','Questions has been updated successfully');
    }


    public function destroy(Question $question)
    {
        $this->authorize('delete',$question);

        $question->delete();

        if(request()->expectsJson()){
            return response()->json([
                'message'=>'Question has been Deleted successfully'
            ]);
        }

        return redirect()->back()->with('success','Questions has been deleted successfully');

    }
}
