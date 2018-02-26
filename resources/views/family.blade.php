@extends('layouts.general')


@section('title', 'Family members overview')


@section('header')

    <h1>Family
        <small>members</small>
    </h1>

@endsection




@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="portlet light">

                <div class="portlet-title">
                    <div class="caption caption-md">
                        <i class="icon-bar-chart font-dark hide"></i>
                        <span class="caption-subject font-green-steel uppercase bold">Quick overview</span>
                    </div>
                </div>

                <div class="portlet-body form">

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th> Name </th>
                                <th> Email </th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse(\App\User::where('family_id', Auth::user()->family_id)->get() as $user)
                                <tr>
                                    <td> @if($user->name == 'N/A') <i>Never logged in</i> @else {{ $user->name }} @endif</td>
                                    <td> {{ $user->email }} </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2">Your family has no members. Strange!</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>


@endsection
