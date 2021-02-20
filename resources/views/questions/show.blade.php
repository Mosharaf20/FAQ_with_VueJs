@extends('layouts.app')

@section('content')

<questions :question="{{$question}}"></questions>

@endsection
