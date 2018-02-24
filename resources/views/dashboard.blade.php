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

                            <select class="bs-select form-control" data-show-subtext="true" tabindex="-98" name="category">
                                <option></option>

                                <optgroup label="EXPENSES">
                                    @foreach(\App\Category::where('is_positive', false)->orderBy('name')->get() as $category)
                                        <option value="{{ $category->id }}" @if(old('category') == $category->id) selected @endif data-content="{{ $category->name }} <span class='label lable-sm bg-red bg-font-red'> OUT </span>">
                                            OUT - {{ $category->name }}
                                        </option>
                                    @endforeach
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



            <div class="portlet light ">
                <div class="portlet-title tabbable-line">
                    <div class="caption caption-md">
                        <i class="icon-globe theme-font hide"></i>
                        <span class="caption-subject font-blue-madison bold uppercase">Last movements</span>
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
                            <div class="scroller" style="height: 320px;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
                                <ul class="feeds">

                                    @foreach(\App\Record::orderBy('created_at', 'desc')->take(30)->get() as $record)
                                        <li>
                                            <div class="col1">
                                                <div class="cont">
                                                    <div class="cont-col1">
                                                        @if($record->category->is_positive)
                                                            <span class='label lable-sm bg-green-jungle bg-font-green-jungle'> +{{ number_format($record->amount/100, 2) }} </span>
                                                        @else
                                                            <span class='label lable-sm bg-red bg-font-red'> -{{ number_format($record->amount/100, 2) }} </span>
                                                        @endif
                                                    </div>
                                                    <div class="cont-col2">
                                                        <div class="desc">
                                                            <b>{{ $record->user->name }}:</b>  {{ $record->comment }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col2">
                                                <div class="date"> {{ \Carbon\Carbon::createFromTimeStamp(strtotime($record->created_at))->diffForHumans() }} </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_1_2">
                            <div class="scroller" style="height: 337px;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
                                <ul class="feeds">
                                    @foreach(\App\Record::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->take(30)->get() as $record)
                                        <li>
                                            <div class="col1">
                                                <div class="cont">
                                                    <div class="cont-col1">
                                                        @if($record->category->is_positive)
                                                            <span class='label lable-sm bg-green-jungle bg-font-green-jungle'> +{{ number_format($record->amount/100, 2) }} </span>
                                                        @else
                                                            <span class='label lable-sm bg-red bg-font-red'> -{{ number_format($record->amount/100, 2) }} </span>
                                                        @endif
                                                    </div>
                                                    <div class="cont-col2">
                                                        <div class="desc">
                                                            <b>{{ $record->user->name }}:</b>  {{ $record->comment }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col2">
                                                <div class="date"> {{ \Carbon\Carbon::createFromTimeStamp(strtotime($record->created_at))->diffForHumans() }} </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--END TABS-->
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
