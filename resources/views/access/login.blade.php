@extends('layouts.general')


@section('title', 'Login required')


@section('header')

    <h1>You need to login
        <small>in order to use this app</small>
    </h1>

@endsection


@section('content')

    <div class="col-md-12">
        <div class="m-heading-1 border-green m-bordered">
            <p>
                Sorry, this is a private application. You need to log in before you can do something.
            </p>
            <p>
                If you already have an enabled account, you can access by using the red button top right.
            </p>
        </div>
    </div>

@endsection