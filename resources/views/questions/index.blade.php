@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex">
                        <h3>All Questions</h3>
                        <h4 class="ml-auto btn btn-info">
                            <a class="text-decoration-none text-white" href="{{route('questions.create')}}">New Question</a>
                        </h4>
                    </div>

                    <div class="card-body">
                        <x-messages/>
                        @foreach($questions as $question)
                            <div class="">
                               <div class="d-flex ">
                                   <h3><a href="{{route('questions.show',$question->slug)}}">{{$question->title}}</a></h3>
                                   <div class="btn-group ml-auto">
                                      @can('update-question',$question)
                                           <button class="btn-sm btn-success mr-2"><a href="{{route('questions.edit',$question->id)}}" class="text-decoration-none text-white">Edit</a></button>
                                      @endcan
                                      @can('destroy-question',$question)
                                           <button onclick="event.preventDefault(); document.getElementById('question-{{$question->id}}').submit();" class="btn-sm btn-danger">Delete</button>
                                          <form class="d-none" id="question-{{$question->id}}" action="{{route('questions.destroy',$question->id)}}" method="post">
                                              @method('DELETE')
                                              @csrf
                                          </form>
                                      @endcan
                                   </div>
                               </div>
                                <div class="author">
                                    <h5>
                                        <small>Created By</small>
                                        <b>{{$question->user->name}}</b>
                                        <small>{{$question->created_date}}</small>
                                    </h5>
                                </div>
                               <p>{!! $question->body_html !!}</p>
                            </div>
                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="text-center">
                {{$questions->links()}}
            </div>
        </div>
    </div>
@endsection
