@extends('layouts.general')


@section('title', 'Family members')


@section('header')

    <h1>Family members
        <small>management</small>
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
                            <span class="caption-subject font-green-steel uppercase bold">Manage my family members</span>
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
                                    @php
                                        $family_id = Auth::user()->family_id;
                                    @endphp
                                    @foreach(\App\User::where('family_id', $family_id)->get() as $user)
                                        <tr>
                                            <td>
                                                {{ $user->name }} <a href="#" data-target="#modal_demo_{{ $user->id }}" data-toggle="modal"><span class="label label-sm label-info"><i class="fa fa-edit"></i> Edit</span></a>

                                                <div id="modal_demo_{{ $user->id }}" class="modal fade" role="dialog" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog">
                                                        <form action="{{ url('family/name') }}" method="post">

                                                            @csrf

                                                            <input type="hidden" value="{{ $user->id }}" name="user_id" />

                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                                    <h4 class="modal-title">Rename user</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <label>Display name:</label>
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-user"></i>
                                                                            </span>
                                                                            <input type="text" class="form-control" placeholder="Please insert a name" required name="name" value="{{ $user->name }}" />
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button class="btn dark btn-outline" data-dismiss="modal" aria-hidden="true">Close</button>
                                                                    <button type="submit" class="btn blue">Save changes</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                            <td> {{ $user->email }} </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

                <div class="portlet light">

                    <div class="portlet-title">
                        <div class="caption caption-md">
                            <i class="icon-bar-chart font-dark hide"></i>
                            <span class="caption-subject font-green-steel uppercase bold">Add member</span>
                        </div>
                    </div>

                    <div class="portlet-body form">

                        <form action="{{ url('family/add') }}" method="post">

                            @csrf

                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-envelope"></i>
                                </span>
                                <input type="email" class="form-control" placeholder="Email Address" name="email" required>
                            </div>

                            <div class="form-actions right">
                                <button type="submit" class="btn green">Add new family member</button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>


@endsection