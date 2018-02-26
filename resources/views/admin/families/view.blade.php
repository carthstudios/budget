@extends('layouts.general')


@section('title', 'Families management')


@section('header')

    <h1>Families and members
        <small>management</small>
    </h1>

@endsection




@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                @if($errors->any())
                    <div class="alert alert-danger">
                        <strong>Error!</strong> {{ $errors->first() }}
                    </div>
                @endif

                @if(session()->has('success'))
                    <div class="alert alert-success">
                        <strong>Success!</strong> {{ session()->get('success') }}
                    </div>
                @endif


                <div class="portlet light">

                    <div class="portlet-title">
                        <div class="caption caption-md">
                            <i class="icon-bar-chart font-dark hide"></i>
                            <span class="caption-subject font-green-steel uppercase bold">Manage families and members</span>
                        </div>
                    </div>

                    <div class="portlet-body form">

                        @foreach(\App\Family::get() as $family)

                            <br />
                            <h4>Family: <b>{{ $family->name }}</b></h4>

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th> Name </th>
                                            <th> Email </th>
                                            <th> Actions </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($family->members as $user)
                                            <tr>
                                                <td>
                                                    {{ $user->name }} <a href="#" data-target="#modal_demo_{{ $user->id }}" data-toggle="modal"><span class="label label-sm label-info"><i class="fa fa-edit"></i> Edit</span></a>

                                                    <div id="modal_demo_{{ $user->id }}" class="modal fade" role="dialog" aria-hidden="true" style="display: none;">
                                                        <div class="modal-dialog">
                                                            <form action="{{ url('admin/families/member/rename') }}" method="post">

                                                                @csrf

                                                                <input type="hidden" value="{{ $user->id }}" name="user_id" />

                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                                        <h4 class="modal-title">Rename user</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="form-group">
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
                                                <td> <a href="{{ url('admin/families/member/remove/' . $user->id) }}"><span class="label label-sm label-danger"><i class="fa fa-remove"></i> Remove</span></a> </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3">This family has no members</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                        @endforeach


                        <br />
                        <h4>Users without a family:</h4>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th> Email </th>
                                    <th> Family </th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse(\App\User::whereNull('family_id')->get() as $user)
                                    <tr>
                                        <td> {{ $user->email }} </td>
                                        <td>
                                            <form action="{{ url('admin/families/member/add') }}" method="post">

                                                @csrf

                                                <input type="hidden" value="{{ $user->id }}" name="user_id" />

                                                <select class="bs-select" data-show-subtext="true" tabindex="-98" name="family_id" data-container="body">
                                                    <option></option>

                                                    @foreach(\App\Family::get() as $family)
                                                        <option value="{{ $family->id }}" data-content="{{ $family->name }}">{{ $family->name }}</option>
                                                    @endforeach
                                                </select>

                                                <button type="submit" class="btn green">Add</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="">No users found</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="portlet light">

                    <div class="portlet-title">
                        <div class="caption caption-md">
                            <i class="icon-bar-chart font-dark hide"></i>
                            <span class="caption-subject font-green-steel uppercase bold">Add member to a family</span>
                        </div>
                    </div>

                    <div class="portlet-body form">

                        <form action="{{ url('admin/families/member/add_new') }}" method="post">

                            @csrf

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-envelope"></i>
                                    </span>
                                    <input type="email" class="form-control" placeholder="Email Address" name="email" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <select class="bs-select form-control" data-show-subtext="true" name="family_id" id="add_new_to_family">
                                    <option></option>

                                    @foreach(\App\Family::get() as $family)
                                        <option value="{{ $family->id }}" data-content="{{ $family->name }}">{{ $family->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-actions right">
                                <button type="submit" class="btn green">Add new member</button>
                            </div>

                        </form>

                    </div>
                </div>


                <div class="portlet light">

                    <div class="portlet-title">
                        <div class="caption caption-md">
                            <i class="icon-bar-chart font-dark hide"></i>
                            <span class="caption-subject font-green-steel uppercase bold">Add new family</span>
                        </div>
                    </div>

                    <div class="portlet-body form">

                        <form action="{{ url('admin/families/add') }}" method="post">

                            @csrf

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-user-plus"></i>
                                    </span>
                                    <input type="text" class="form-control" placeholder="Name of new family" name="family_name" required>
                                </div>
                            </div>

                            <div class="form-actions right">
                                <button type="submit" class="btn green">Create family</button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>


@endsection