@extends('layouts.general')


@section('title', 'Not authorized')


@section('header')

    <h1>You are not authorized
        <small>to access this application</small>
    </h1>

@endsection


@section('content')

    <div class="col-md-12">
        <div class="m-heading-1 border-green m-bordered">
            <p>
                Sorry, your account is not authorized (yet) to use this application.
            </p>
            <p>
                You should get in contact with an administrator.
            </p>
        </div>
    </div>

@endsection