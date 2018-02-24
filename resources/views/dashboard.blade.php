@extends('layouts.general')


@section('title', 'Dashboard')


@section('header')

    <h1>Dashboard
        <small>for the user</small>
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
                        <span class="caption-subject font-green-steel uppercase bold">Record a movement</span>
                    </div>
                </div>

                <div class="portlet-body form">

                    <form action="{{ url('/records/create') }}" method="post">

                        @csrf

                        @if($errors->count())
                            <div class="form-group">
                                <div class="note note-danger">
                                    <p> {{ $errors->first() }}</p>
                                </div>
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="amount" class="control-label">Amount</label>
                            <div class="input-icon">
                                <i class="fa fa-money"></i>
                                <input type="text" class="form-control" placeholder="0.00" id="amount" name="amount" required value="{{ old('amount') }}"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="single" class="control-label">
                                <i class="fa fa-folder-open-o"></i>
                                Category
                            </label>

                            <select id="single" class="form-control select2" name="category">
                                <option></option>

                                <optgroup label="INCOMES">
                                    @foreach(\App\Category::where('is_positive', true)->orderBy('name')->get() as $category)
                                        <option value="{{ $category->id }}" @if(old('category') == $category->id) selected @endif>
                                            IN - {{ $category->name }}
                                        </option>
                                    @endforeach
                                </optgroup>

                                <optgroup label="EXPENSES">
                                    @foreach(\App\Category::where('is_positive', false)->orderBy('name')->get() as $category)
                                        <option value="{{ $category->id }}" @if(old('category') == $category->id) selected @endif>
                                            OUT - {{ $category->name }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Comment</label>
                            <div class="input-icon">
                                <i class="fa fa-file-text-o"></i>
                                <input type="text" class="form-control" placeholder="Write something" name="comment" required value="{{ old('comment') }}" />
                            </div>
                        </div>

                        <div class="form-actions right">
                            <button type="button" class="btn purple-sharp" data-target="#modal_demo_2" data-toggle="modal" style="width: 120px;">
                                <i class="fa fa-cog"></i>
                                Options
                            </button>

                            <button type="submit" data-loading-text="Loading..." class="btn blue"  style="width: 120px;">
                                <i class="fa fa-save"></i>
                                Save
                            </button>
                        </div>

                        <div id="modal_demo_2" class="modal fade" role="dialog" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Options</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Currency</label>
                                            <div class="input-icon">

                                                <div class="md-radio-inline">
                                                    <div class="md-radio">
                                                        <input type="radio" id="checkbox1_8" name="currency" class="md-radiobtn" value="CHF" @if(old('currency', 'CHF') == 'CHF') checked @endif>
                                                        <label for="checkbox1_8">
                                                            <span></span>
                                                            <span class="check"></span>
                                                            <span class="box"></span> CHF </label>
                                                    </div>
                                                    <div class="md-radio">
                                                        <input type="radio" id="checkbox1_9" name="currency" class="md-radiobtn" value="EUR" @if(old('currency') == 'EUR') checked @endif>
                                                        <label for="checkbox1_9">
                                                            <span></span>
                                                            <span class="check"></span>
                                                            <span class="box"></span> EUR </label>
                                                    </div>
                                                    <div class="md-radio">
                                                        <input type="radio" id="checkbox1_10" name="currency" class="md-radiobtn" value="USD" @if(old('currency') == 'USD') checked @endif>
                                                        <label for="checkbox1_10">
                                                            <span></span>
                                                            <span class="check"></span>
                                                            <span class="box"></span> USD </label>
                                                    </div>
                                                    <div class="md-radio">
                                                        <input type="radio" id="checkbox1_11" name="currency" class="md-radiobtn" value="SGD" @if(old('currency') == 'SGD') checked @endif>
                                                        <label for="checkbox1_11">
                                                            <span></span>
                                                            <span class="check"></span>
                                                            <span class="box"></span> SGD </label>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn dark btn-outline" data-dismiss="modal" aria-hidden="true">Close</button>
                                        <button class="btn blue" data-dismiss="modal">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>


@endsection
