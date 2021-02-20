@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Modify The Questions</div>

                    <div class="card-body">
                        <form action="{{route('questions.update',$question->id)}}" method="post">
                            @method('patch')
                            @csrf
                            <div class="form-group">
                                <label for="title">Modify meaningful question title</label>
                                <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" value="{{old('title') ?? $question->title}} ">
                                @error('title')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="body">Write down description</label>
                                <textarea name="body" id="body" class="form-control @error('body') is-invalid @enderror" rows="7">{{old('body') ?? $question->title}}</textarea>
                                @error('body')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <button class="btn btn-success">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
