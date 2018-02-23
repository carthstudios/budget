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
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption caption-md">
                        <i class="icon-bar-chart font-dark hide"></i>
                        <span class="caption-subject font-green-steel uppercase bold">Record a movement</span>
                    </div>
                </div>
                <div class="portlet-body">

                    <form action=""
                    <div class="form-group">
                        <label>Amount</label>
                        <div class="input-icon input-icon-lg">
                            <i class="fa fa-money"></i>
                            <input type="text" class="form-control input-lg" placeholder="0.00 CHF" name="amount" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label>
                            <i class="fa fa-folder-open-o"></i>
                            Category
                        </label>
                        <select class="form-control input-lg" name="category" required>
                            <option selected>Please select...</option>
                            @foreach(\App\Category::orderBy('is_positive')->get() as $category)
                                <option value="{{ $category->id }}">
                                    @if($category->is_positive)
                                        IN
                                    @else
                                        OUT
                                    @endif
                                    - {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Comment</label>
                        <div class="input-icon input-icon-lg">
                            <i class="fa fa-file-text-o"></i>
                            <input type="text" class="form-control input-lg" placeholder="Write something" name="comment" required />
                        </div>
                    </div>
                    <div class="form-actions right">
                        <button type="submit" disabled data-loading-text="Loading..." class="btn btn-lg btn-block blue mt-ladda-btn ladda-button mt-progress-demo" data-style="slide-right">
                            <span class="ladda-label">
                                <i class="fa fa-save"></i>
                                Save
                            </span>
                            <span class="ladda-spinner"></span><span class="ladda-spinner"></span>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
