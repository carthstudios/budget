@extends('layouts.general')


@section('title', 'Budget configuration')


@section('header')

    <h1>Family budget
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
                <span class="caption-subject font-green-steel uppercase bold">Monthly family budget</span>
            </div>
        </div>

        <div class="portlet-body form">

            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th> &nbsp; </th>
                            <th> Category </th>
                            <th> Expected movement </th>
                            <th> Actions </th>
                        </tr>
                    </thead>
                    <tbody>
                    @php
                        $budgets = \App\BudgetMonthlyPlan::where('family_id', Auth::user()->family_id)->get();
                    @endphp

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
                            <td>
                                {{ $category->name }}
                            </td>
                            <td>
                                @php
                                    $amount             = "Not defined";
                                    $comment            = null;
                                    $monthly_plan_id    = 0;

                                    if ($budgets->where('category_id', $category->id)->count() > 0)
                                    {
                                        $amount             = $budgets->where('category_id', $category->id)->first()->amount;
                                        $amount             = $amount > 0 ? number_format($amount / 100, 2) : "Not defined";
                                        $comment            = $budgets->where('category_id', $category->id)->first()->comment;
                                        $monthly_plan_id    = $budgets->where('category_id', $category->id)->first()->id;
                                    }
                                @endphp

                                {{ $amount }}

                                @if(strlen($comment) > 0)
                                    <a class="mt-sweetalert" data-title="Comment" data-message="{{ $comment }}" data-type="info" data-allow-outside-click="true" data-confirm-button-class="btn-info">
                                        <span class='label lable-sm bg-blue bg-font-blue'> Info </span>
                                    </a>
                                @endif
                            </td>
                            <td>
                                @if($category->id != \App\BudgetPutAsidePlan::PUTSIDE_CATEGORY_ID)
                                    <a data-target="#modal_monthly_{{ $category->id }}" data-toggle="modal">
                                        <span class='label lable-sm bg-green bg-font-green'>
                                            <i class="fa fa-edit"></i>
                                            Edit
                                        </span>
                                    </a>
                                @endif

                                <div id="modal_monthly_{{ $category->id }}" class="modal fade" role="dialog" aria-hidden="true" style="display: none;">
                                    <form action="{{ url('config/budget/mupdate') }}" method="post">

                                        @csrf

                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">Edit monthly plan</h4>
                                                </div>
                                                <div class="modal-body">

                                                    <div class="form-group">
                                                        <label>Amount of expected movement</label>
                                                        <div class="input-icon">
                                                            <i class="fa fa-money"></i>
                                                            <input type="number" class="form-control" placeholder="0.00" id="amount" name="amount" step="0.01" min="0" value="{{ $amount }}" />
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Comment</label>
                                                        <div class="input-icon">
                                                            <i class="fa fa-file-text-o"></i>
                                                            <input type="text" class="form-control" placeholder="Write something" name="comment" value="{{ $comment }}" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="hidden" name="category_id" value="{{ $category->id }}" />
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

        </div>
    </div>

    <div class="portlet light">

        <div class="portlet-title">
            <div class="caption caption-md">
                <i class="icon-bar-chart font-dark hide"></i>
                <span class="caption-subject font-green-steel uppercase bold">Put aside plan</span>
            </div>
        </div>

        <div class="portlet-body form">

            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th> &nbsp; </th>
                            <th> Category </th>
                            <th> Comment </th>
                            <th> Yearly movement </th>
                            <th> Monthly share </th>
                            <th> Actions </th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse(\App\BudgetPutAsidePlan::where('family_id', Auth::user()->family_id)->get() as $putAside)
                        <tr>
                            <td>
                                @if($putAside->category->id == \App\BudgetPutAsidePlan::PUTSIDE_CATEGORY_ID)
                                    <span class='label lable-sm bg-blue bg-font-blue'> ACC </span>
                                @elseif($putAside->category->is_positive)
                                    <span class='label lable-sm bg-green-jungle bg-font-green-jungle'> IN </span>
                                @else
                                    <span class='label lable-sm bg-red bg-font-red'> OUT </span>
                                @endif
                            </td>

                            <td> {{ $putAside->category->name }} </td>
                            <td> {{ $putAside->comment }} </td>

                            <td> {{ number_format($putAside->amount / 100, 2) }} </td>
                            <td> {{ number_format(($putAside->amount / 12) / 100, 2) }} </td>

                            <td>
                                <a data-target="#modal_putaside_{{ $category->id }}" data-toggle="modal">
                                    <span class='label lable-sm bg-green bg-font-green'>
                                        <i class="fa fa-edit"></i>
                                        Edit
                                    </span>
                                </a>

                                &nbsp;

                                <a href="{{ url('config/budget/premove/' . $putAside->id) }}">
                                    <span class='label lable-sm bg-green bg-font-green'>
                                        <i class="fa fa-remove"></i>
                                        Remove
                                    </span>
                                </a>

                                <div id="modal_putaside_{{ $category->id }}" class="modal fade" role="dialog" aria-hidden="true" style="display: none;">
                                    <form action="{{ url('config/budget/pupdate') }}" method="post">

                                        @csrf

                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">Edit put aside record</h4>
                                                </div>
                                                <div class="modal-body">

                                                    <div class="form-group">
                                                        <label for="single" class="control-label">
                                                            <i class="fa fa-folder-open-o"></i>
                                                            Category
                                                        </label>
                                                        <br />
                                                        <select class="bs-select form-control" data-show-subtext="true" tabindex="-98" name="category_id"  data-container="body" required>
                                                            <option></option>

                                                            @foreach(\App\Category::where('is_positive', false)->orderBy('name')->get() as $category)
                                                                @if($category->id != \App\BudgetPutAsidePlan::PUTSIDE_CATEGORY_ID)
                                                                    <option value="{{ $category->id }}" @if($putAside->category->id == $category->id) selected @endif data-content="{{ $category->name }} <span class='label lable-sm bg-red bg-font-red'> OUT </span>">
                                                                        OUT - {{ $category->name }}
                                                                    </option>
                                                                @endif
                                                            @endforeach

                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Comment</label>
                                                        <div class="input-icon">
                                                            <i class="fa fa-file-text-o"></i>
                                                            <input type="text" class="form-control" placeholder="Write something" name="comment" value="{{ $putAside->comment }}" />
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Amount expected</label>
                                                        <div class="input-icon">
                                                            <i class="fa fa-money"></i>
                                                            <input type="number" class="form-control" placeholder="0.00" id="amount" name="amount" step="0.01" min="0" value="{{ $putAside->amount / 100 }}" />
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <input type="hidden" name="putaside_id" value="{{ $putAside->id }}" />
                                                    <button class="btn dark btn-outline" data-dismiss="modal" aria-hidden="true">Close</button>
                                                    <button type="submit" class="btn blue">Save changes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No records to show</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <h4 class="form-section"><b>Add new put aside record</b></h4>

            <form action="{{ url('config/budget/padd') }}" method="post">

                @csrf

                <div class="form-group">
                    <label for="single" class="control-label">
                        <i class="fa fa-folder-open-o"></i>
                        Category
                    </label>

                    <select class="bs-select form-control" data-show-subtext="true" tabindex="-98" name="category_id"  data-container="body" required>
                        <option></option>

                        @foreach(\App\Category::where('is_positive', false)->orderBy('name')->get() as $category)
                            @if($category->id != \App\BudgetPutAsidePlan::PUTSIDE_CATEGORY_ID)
                                <option value="{{ $category->id }}" data-content="{{ $category->name }} <span class='label lable-sm bg-red bg-font-red'> OUT </span>">
                                    OUT - {{ $category->name }}
                                </option>
                            @endif
                        @endforeach

                    </select>
                </div>

                <div class="form-group">
                    <label>Comment</label>
                    <div class="input-icon">
                        <i class="fa fa-file-text-o"></i>
                        <input type="text" class="form-control" placeholder="Write something" name="comment" required />
                    </div>
                </div>

                <div class="form-group">
                    <label>Amount expected</label>
                    <div class="input-icon">
                        <i class="fa fa-money"></i>
                        <input type="number" class="form-control" placeholder="0.00" id="amount" name="amount" step="0.01" min="0" required />
                    </div>
                </div>

                <div class="form-actions right">
                    <button type="submit" class="btn blue">
                        <i class="fa fa-save"></i>
                        Add new record
                    </button>
                </div>

            </form>

        </div>
    </div>

@endsection
