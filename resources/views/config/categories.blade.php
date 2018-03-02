@extends('layouts.general')


@section('title', 'Categories configuration')


@section('header')

    <h1>Categories
        <small>configuration</small>
    </h1>

@endsection




@section('content')

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
                <span class="caption-subject font-green-steel uppercase bold">Categories</span>
            </div>
        </div>

        <div class="portlet-body form">

            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th> &nbsp; </th>
                            <th> Category name </th>
                            <th> Actions </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Category::orderBy('is_positive')->orderBy('name')->get() as $category)
                            <tr>
                                <td>
                                    @if($category->id == \App\BudgetPutAsidePlan::PUTSIDE_CATEGORY_ID)
                                        <span class='label lable-sm bg-blue bg-font-blue'> ACC </span>
                                    @elseif($category->is_positive)
                                        <span class='label lable-sm bg-green-jungle bg-font-green-jungle'> IN </span>
                                    @else
                                        <span class='label lable-sm bg-red bg-font-red'> OUT </span>
                                    @endif
                                </td>
                                <td> {{ $category->name }} </td>
                                <td>
                                    @if($category->id != \App\BudgetPutAsidePlan::PUTSIDE_CATEGORY_ID)
                                        <a data-target="#modal_edit_{{ $category->id }}" data-toggle="modal">
                                            <span class='label lable-sm bg-green bg-font-green'>
                                                <i class="fa fa-edit"></i>
                                                Edit
                                            </span>
                                        </a>

                                        @if(\App\Record::where('category_id', $category->id)->get()->count() == 0)
                                            &nbsp;
                                            <a href="{{ url('config/categories/remove/' . $category->id) }}">
                                                <span class='label lable-sm bg-green bg-font-green'>
                                                    <i class="fa fa-remove"></i>
                                                    Remove
                                                </span>
                                            </a>
                                        @endif
                                    @endif

                                    <div id="modal_edit_{{ $category->id }}" class="modal fade" role="dialog" aria-hidden="true" style="display: none;">
                                        <form action="{{ url('config/categories/edit/' . $category->id) }}" method="post">

                                            @csrf

                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                        <h4 class="modal-title">Edit category</h4>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="form-group">
                                                            <label>Name</label>
                                                            <div class="input-icon">
                                                                <i class="fa fa-file-text-o"></i>
                                                                <input type="text" class="form-control" placeholder="Write something" name="name" value="{{ $category->name }}" />
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Type</label>

                                                            <div class="input-icon">
                                                                <div class="md-radio-inline">
                                                                    <div class="md-radio">
                                                                        <input type="radio" id="checkbox1_{{ $category->id }}" name="is_positive" class="md-radiobtn" value="true" @if($category->is_positive) checked @endif />
                                                                        <label for="checkbox1_{{ $category->id }}">
                                                                            <span></span>
                                                                            <span class="check"></span>
                                                                            <span class="box"></span>
                                                                            IN
                                                                        </label>
                                                                    </div>

                                                                    <div class="md-radio">
                                                                        <input type="radio" id="checkbox2_{{ $category->id }}" name="is_positive" class="md-radiobtn" value="false" @if($category->is_positive == 0) checked @endif />
                                                                        <label for="checkbox2_{{ $category->id }}">
                                                                            <span></span>
                                                                            <span class="check"></span>
                                                                            <span class="box"></span>
                                                                            OUT
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="modal-footer">
                                                        <button class="btn dark btn-outline" data-dismiss="modal" aria-hidden="true">Close</button>
                                                        <button type="submit" class="btn blue">Save changes</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


            <h4 class="form-section"><b>Add new category</b></h4>

            <form action="{{ url('config/categories/add') }}" method="post">

                @csrf

                <div class="form-group">
                    <label>Name</label>
                    <div class="input-icon">
                        <i class="fa fa-file-text-o"></i>
                        <input type="text" class="form-control" placeholder="Provide a name / short description" name="name" required value="{{ old('name') }}" />
                    </div>
                </div>

                <div class="form-group">
                    <label>Type</label>

                    <div class="input-icon">
                        <div class="md-radio-inline">
                            <div class="md-radio">
                                <input type="radio" id="checkbox1_newcat" name="is_positive" class="md-radiobtn" value="true" @if(old('is_positive')) checked @endif />
                                <label for="checkbox1_newcat">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span>
                                    IN
                                </label>
                            </div>

                            <div class="md-radio">
                                <input type="radio" id="checkbox2_newcat" name="is_positive" class="md-radiobtn" value="false" @if(old('is_positive') == false) checked @endif  />
                                <label for="checkbox2_newcat">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span>
                                    OUT
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions right">
                    <button type="submit" class="btn blue">
                        <i class="fa fa-save"></i>
                        Add new category
                    </button>
                </div>

            </form>


        </div>
    </div>


@endsection
