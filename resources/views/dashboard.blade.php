@extends('layouts.general')


@section('title', 'Dashboard')


@section('header')

    <h1>Dashboard
        <small>for the user</small>
    </h1>

@endsection




@section('content')

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

                <div class="form-group">
                    <label for="amount" class="control-label">Amount</label>
                    <div class="input-icon">
                        <i class="fa fa-money"></i>
                        <input type="number" class="form-control" placeholder="0.00" id="amount" name="amount" required value="{{ old('amount') }}" step="0.01" min="0" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="single" class="control-label">
                        <i class="fa fa-folder-open-o"></i>
                        Category
                    </label>

                    <select class="bs-select form-control" data-show-subtext="true" tabindex="-98" name="category">
                        <option></option>

                        <optgroup label="EXPENSES">
                            @foreach(\App\Category::where('is_positive', false)->orderBy('name')->get() as $category)
                                @if($category->id != \App\BudgetPutAsidePlan::PUTSIDE_CATEGORY_ID)
                                    <option value="{{ $category->id }}" @if(old('category') == $category->id) selected @endif data-content="{{ $category->name }} <span class='label lable-sm bg-red bg-font-red'> OUT </span>">
                                        OUT - {{ $category->name }}
                                    </option>
                                @endif
                            @endforeach
                        </optgroup>

                        <optgroup label="DEPOSITS">
                            <option value="{{ \App\BudgetPutAsidePlan::PUTSIDE_CATEGORY_ID }}"
                                    @if(old('category') == \App\BudgetPutAsidePlan::PUTSIDE_CATEGORY_ID) selected @endif
                                    data-content="{{ \App\Category::find(\App\BudgetPutAsidePlan::PUTSIDE_CATEGORY_ID)->name }} <span class='label lable-sm bg-blue bg-font-blue'> ACC </span>">
                                ACC - {{ $category->name }}
                            </option>
                        </optgroup>

                        <optgroup label="INCOMES">
                            @foreach(\App\Category::where('is_positive', true)->orderBy('name')->get() as $category)
                                <option value="{{ $category->id }}" @if(old('category') == $category->id) selected @endif data-content="{{ $category->name }} <span class='label lable-sm bg-green-jungle bg-font-green-jungle'> IN </span>">
                                    IN - {{ $category->name }}
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

                                <div class="form-group">
                                    <label>Date of the movement</label>

                                    <div class="input-group date bs-datetime date-picker">
                                        <input class="form-control" type="text" name="date" value="{{ old('date') }}"/>
                                        <span class="input-group-addon">
                                            <button class="btn default date-set" type="button">
                                                <i class="fa fa-calendar"></i>
                                            </button>
                                        </span>
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn dark btn-outline" data-dismiss="modal" aria-hidden="true">Close</button>
                                <button class="btn blue" data-dismiss="modal">Save option</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>



    <div class="portlet light ">
        <div class="portlet-title tabbable-line">
            <div class="caption caption-md">
                <i class="icon-globe theme-font hide"></i>
                <span class="caption-subject font-blue-madison bold uppercase">Last movements created</span>
            </div>
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#tab_1_1" data-toggle="tab"> All famility </a>
                </li>
                <li>
                    <a href="#tab_1_2" data-toggle="tab"> Mine only </a>
                </li>
            </ul>
        </div>
        <div class="portlet-body">
            <!--BEGIN TABS-->
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1_1">
                    <ul class="transactions">
                        @php
                            $records = \App\Record::where('family_id', Auth::user()->family_id)->orderBy('created_at', 'desc')->take(15)->get();
                        @endphp
                        @foreach($records as $record)
                            <li>
                                <div class="col1" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    <b> {{ $record->user->name }}</b>
                                    <br />
                                    {{ $record->category->name }}
                                    <br />
                                    <a class="mt-sweetalert" data-title="{{ $record->category->name }}" data-message="{{ $record->comment }} (Took place on: {{ $record->date->format('j M Y') }})" data-type="info" data-allow-outside-click="true" data-confirm-button-class="btn-info">
                                        <i>{{ $record->comment }} (Took place on: {{ $record->date->format('j M Y') }})</i>
                                    </a>
                                </div>
                                <div class="col2">
                                    <div class="date">
                                        {{ \Carbon\Carbon::createFromTimeStamp(strtotime($record->created_at))->diffForHumans() }}
                                    </div>

                                    @if($record->category->id == \App\BudgetPutAsidePlan::PUTSIDE_CATEGORY_ID)
                                        <span class='label lable-sm bg-blue bg-font-blue'>-{{ number_format($record->amount/100, 2) }}</span>
                                    @elseif($record->category->is_positive)
                                        <span class='label lable-sm bg-green-jungle bg-font-green-jungle'>+{{ number_format($record->amount/100, 2) }}</span>
                                    @else
                                        <span class='label lable-sm bg-red bg-font-red'>-{{ number_format($record->amount/100, 2) }}</span>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="tab-pane" id="tab_1_2">
                    <ul class="transactions">
                        @php
                            $records = \App\Record::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->take(30)->get()
                        @endphp
                        @foreach($records as $record)
                            <li>
                                <div class="col1" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    <b> {{ $record->user->name }}</b>
                                    <br />
                                    {{ $record->category->name }}
                                    <br />
                                    <a class="mt-sweetalert" data-title="{{ $record->category->name }}" data-message="{{ $record->comment }} (Took place on: {{ $record->date->format('j M Y') }})" data-type="info" data-allow-outside-click="true" data-confirm-button-class="btn-info">
                                        <i>{{ $record->comment }} (Took place on: {{ $record->date->format('j M Y') }})</i>
                                    </a>
                                </div>
                                <div class="col2">
                                    <div class="date">
                                        {{ \Carbon\Carbon::createFromTimeStamp(strtotime($record->created_at))->diffForHumans() }}
                                    </div>

                                    @if($record->category->id == \App\BudgetPutAsidePlan::PUTSIDE_CATEGORY_ID)
                                        <span class='label lable-sm bg-blue bg-font-blue'>-{{ number_format($record->amount/100, 2) }}</span>
                                    @elseif($record->category->is_positive)
                                        <span class='label lable-sm bg-green-jungle bg-font-green-jungle'>+{{ number_format($record->amount/100, 2) }}</span>
                                    @else
                                        <span class='label lable-sm bg-red bg-font-red'>-{{ number_format($record->amount/100, 2) }}</span>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <!--END TABS-->
        </div>
    </div>

@endsection
