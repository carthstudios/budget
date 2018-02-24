@extends('layouts.general')


@section('title', 'Record saved successfully')


@section('header')

    <h1>Dashboard
        <small>for the user</small>
    </h1>

@endsection




@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption caption-md">
                            <i class="icon-bar-chart font-dark hide"></i>
                            <span class="caption-subject font-green-steel uppercase bold">Record a movement</span>
                        </div>
                    </div>
                    <div class="portlet-body">

                        <p>
                            The new record has been saved successfully! Thanks!
                        </p>

                        <p>
                            <a href="{{ url('/') }}">Go back to the Dashboard</a>
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
