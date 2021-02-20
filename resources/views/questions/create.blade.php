@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Create New Questions</div>

                    <div class="card-body">
                        <form action="{{route('questions.store')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="title">Create meaningful question title</label>
                                <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" value="{{old('title')}}">
                                @error('title')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="body">Write down description</label>
                                <textarea name="body" id="body" class="form-control @error('body') is-invalid @enderror" rows="7">{{old('body')}}</textarea>
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
