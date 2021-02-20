@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Update Answer</div>

                    <div class="card-body">
                        <form action="{{route('questions.answers.update',[$question->id,$answer->id])}}" method="post">
                            @method('patch')
                            @csrf
                            <div class="form-group">
                                <label for="body">Write down Answer description</label>
                                <textarea name="body" id="body" class="form-control @error('body') is-invalid @enderror" rows="7">{{$answer->body ?? old('body')}}</textarea>
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
