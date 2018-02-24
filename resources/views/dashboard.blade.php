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

                    @foreach ($errors->all() as $error)


                        <div class="form-group">
                            <div class="note note-danger">
                                <p> {{ $error }}</p>
                            </div>
                        </div>
                        @break

                    @endforeach

                    <form action="{{ url('/records/create') }}" method="post">
                        @csrf

                        <div class="form-group">
                            <label>Amount</label>
                            <div class="input-icon">
                                <i class="fa fa-money"></i>
                                <input type="text" class="form-control" placeholder="0.00 CHF" name="amount" required value="{{ old('amount') }}"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>
                                <i class="fa fa-folder-open-o"></i>
                                Category
                            </label>
                            <select class="form-control" name="category" required>
                                <option selected>Please select...</option>
                                @foreach(\App\Category::orderBy('is_positive')->get() as $category)
                                    <option value="{{ $category->id }}" @if(old('category') == $category->id) selected @endif>
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
                            <div class="input-icon">
                                <i class="fa fa-file-text-o"></i>
                                <input type="text" class="form-control" placeholder="Write something" name="comment" required value="{{ old('comment') }}" />
                            </div>
                        </div>

                        <div class="form-actions right">
                            <button type="submit" data-loading-text="Loading..." class="btn btn-block blue mt-ladda-btn ladda-button mt-progress-demo" data-style="slide-right">
                                <span class="ladda-label">
                                    <i class="fa fa-save"></i>
                                    Save
                                </span>
                                <span class="ladda-spinner"></span><span class="ladda-spinner"></span>
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
