@extends('layouts.general')


@section('title', 'Login required')


@section('header')

    <h1>You need to login
        <small>in order to use this app</small>
    </h1>

@endsection




@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Dashboard</div>

                <div class="card-body">

                    @auth
                        YOu are authenticated as {{ Auth::user()->name }}
                    @else
                        You are not authenticated
                    @endauth

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
