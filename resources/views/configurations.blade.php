@extends('layouts.general')

@section('title', 'Configurations')

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

    <!-- MONTHLY BUDGET START -->
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
                        <th> Category name </th>
                        <th> Expected movement </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
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

                                @if($category->id != \App\BudgetPutAsidePlan::PUTSIDE_CATEGORY_ID)
                                    <a data-target="#update_category_{{ $category->id }}" data-toggle="modal">
                                        <span class='label lable-sm bg-green bg-font-green'><i class="fa fa-edit"></i></span>
                                    </a>

                                    @if($category->records_count == 0)
                                        <a href="{{ url('configurations/category_remove/' . $category->id) }}" style="margin-left: 3px;" data-toggle="confirmation" data-popout="true">
                                            <span class='label lable-sm bg-red-thunderbird bg-font-red-thunderbird'><i class="fa fa-remove"></i></span>
                                        </a>
                                    @endif

                                    <div id="update_category_{{ $category->id }}" class="modal fade" role="dialog" aria-hidden="true" style="display: none;">
                                        <form action="{{ url('configurations/category_edit/' . $category->id) }}" method="post"> @csrf
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
                                                                <input type="text" class="form-control" placeholder="Provide a name" name="name" value="{{ $category->name }}" />
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Type</label>
                                                            <div class="input-icon">
                                                                <div class="md-radio-inline">
                                                                    <div class="md-radio">
                                                                        <input type="radio" id="checkbox1_{{ $category->id }}" name="is_positive" class="md-radiobtn" value="true" @if($category->is_positive) checked @endif />
                                                                        <label for="checkbox1_{{ $category->id }}">
                                                                            <span></span><span class="check"></span><span class="box"></span> IN
                                                                        </label>
                                                                    </div>
                                                                    <div class="md-radio">
                                                                        <input type="radio" id="checkbox2_{{ $category->id }}" name="is_positive" class="md-radiobtn" value="false" @if(!$category->is_positive) checked @endif />
                                                                        <label for="checkbox2_{{ $category->id }}">
                                                                            <span></span><span class="check"></span><span class="box"></span> OUT
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
                                @endif
                            </td>
                            <td>
                                @if($category->amount > 0)
                                    @if($category->is_positive) +@else -@endif{{ number_format($category->amount / 100, 2) }}
                                @else
                                    <small><i class="font-blue-oleo">Not defined</i></small>
                                @endif

                                @if(strlen($category->comment) > 0)
                                    <a class="mt-sweetalert" data-title="Comment" data-message="{{ $category->comment }}" data-type="info" data-allow-outside-click="true" data-confirm-button-class="btn-info">
                                        <span class='label lable-sm bg-blue bg-font-blue'><i class="fa fa-info-circle"></i></span>
                                    </a>
                                @endif

                                @if($category->id != \App\BudgetPutAsidePlan::PUTSIDE_CATEGORY_ID)
                                    <a data-target="#update_budget_{{ $category->id }}" data-toggle="modal" style="margin-left: 3px;">
                                        <span class='label lable-sm bg-green bg-font-green'><i class="fa fa-edit"></i></span>
                                    </a>

                                    <div id="update_budget_{{ $category->id }}" class="modal fade" role="dialog" aria-hidden="true" style="display: none;">
                                        <form action="{{ url('configurations/budget_update/' . $category->id) }}" method="post"> @csrf
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
                                                                <input type="number" class="form-control" placeholder="0.00" id="amount" name="amount" step="0.01" min="0" value="{{ $category->amount / 100 }}" />
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Comment</label>
                                                            <div class="input-icon">
                                                                <i class="fa fa-file-text-o"></i>
                                                                <input type="text" class="form-control" placeholder="Write something" name="comment" value="{{ $category->comment }}" />
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
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <h4 class="form-section"><b>Add new category</b></h4>
            <form action="{{ url('configurations/category_add') }}" method="post"> @csrf
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
    <!-- MONTHLY BUDGET END -->

    <!-- PUT ASIDE START -->
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
                    @forelse($putAsides as $putAside)
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
                                <a data-target="#putaside_edit_{{ $putAside->id }}" data-toggle="modal">
                                    <span class='label lable-sm bg-green bg-font-green'><i class="fa fa-edit"></i> Edit </span>
                                </a>

                                <a href="{{ url('configurations/putaside_remove/' . $putAside->id) }}" style="margin-left: 3px;" data-toggle="confirmation" data-popout="true">
                                    <span class='label lable-sm bg-red-thunderbird bg-font-red-thunderbird'><i class="fa fa-remove"></i> Remove </span>
                                </a>

                                <div id="putaside_edit_{{ $putAside->id }}" class="modal fade" role="dialog" aria-hidden="true" style="display: none;">
                                    <form action="{{ url('configurations/putaside_edit/' . $putAside->id) }}" method="post"> @csrf
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">Edit put aside record</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="single" class="control-label"><i class="fa fa-folder-open-o"></i> Category </label>
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
            <form action="{{ url('configurations/putaside_add') }}" method="post"> @csrf
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
                        <i class="fa fa-save"></i> Add new record
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- PUT ASIDE END -->
@endsection