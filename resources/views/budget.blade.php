@extends('layouts.general')

@section('title', 'Budget overview')


@section('header')

    <h1>Family budget
        <small>status</small>
    </h1>

@endsection


@section('content')

    <div class="portlet light">

        <div class="portlet-title">
            <div class="caption caption-md">
                <i class="icon-bar-chart font-dark hide"></i>
                <span class="caption-subject font-green-steel uppercase bold">Monthly overview</span>
            </div>
            <div class="actions">
                <div class="btn-group btn-group-devided">
                    @php
                        $cursor = with(\Carbon\Carbon::now())->subMonths(6);
                    @endphp
                    @while($cursor->diffInMonths(\Carbon\Carbon::now()) > 0)
                        @php
                            $cursor->addMonth()
                        @endphp
                        <a href="{{ url("budget/" . $cursor->month . "/" . $cursor->year) }}" class="btn btn-transparent btn-no-border blue-oleo btn-outline btn-circle btn-sm @if($cursor->month == $month && $cursor->year == $year) active @endif">
                            {{ $cursor->format("M y") }}
                        </a>
                    @endwhile
                </div>
            </div>
        </div>

        <div class="portlet-body form">

            <div class="table-responsive">

                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th colspan="3" class="bg-green-jungle bg-font-green-jungle"> IN </th>
                            <th colspan="3" class="bg-red-mint bg-font-red-mint"> OUT </th>
                        </tr>
                        <tr>
                            <th width="30%" class="bg-green-dark bg-font-green-dark"> Category </th>
                            <th width="10%" class="bg-green-dark bg-font-green-dark"> Actual </th>
                            <th width="10%" class="bg-green-dark bg-font-green-dark"> Budgeted </th>
                            <th width="30%" class="bg-red-pink bg-font-red-pink"> Category </th>
                            <th width="10%" class="bg-red-pink bg-font-red-pink"> Actual </th>
                            <th width="10%" class="bg-red-pink bg-font-red-pink"> Budgeted </th>
                        </tr>
                    </thead>
                    <tbody>
                    @php
                        $positives = \App\Category::where('is_positive', true)->orderBy('name')->get();
                        $negatives = \App\Category::where('is_positive', false)->orderBy('name')->get();

                        $positives_sum = 0;
                        $negatives_sum = 0;

                        $positives_budget = 0;
                        $negatives_budget = 0;

                        $monthy_records = \App\Record::where('family_id', Auth::user()->family_id)
                                            ->whereMonth('date', $month)
                                            ->whereYear('date', $year)->get();

                        $monthy_budgets = \App\BudgetMonthlyPlan::where('family_id', Auth::user()->family_id)->get();

                    @endphp

                    @while($positives->count() > 0 || $negatives->count() > 0)

                        @php
                            if ($positive = $positives->shift())
                            {
                                // Actual gain
                                $positive_amount = $monthy_records->where('category_id', $positive->id)
                                    ->sum(function ($record) {
                                        return $record->amount;
                                    });

                                $positives_sum += $positive_amount;

                                // Budgeted gain
                                $positive_budget = $monthy_budgets->where('category_id', $positive->id)
                                    ->sum(function ($record) {
                                        return $record->amount;
                                    });

                                $positives_budget += $positive_budget;
                            }
                            else
                            {
                                $positive_budget = 0;
                            }

                            if ($negative = $negatives->shift())
                            {
                                // Actual spent
                                $negative_amount = $monthy_records->where('category_id', $negative->id)
                                    ->sum(function ($record) {
                                        return $record->amount;
                                    });

                                $negatives_sum += $negative_amount;

                                // Budgeted spent
                                $negative_budget = $monthy_budgets->where('category_id', $negative->id)
                                    ->sum(function ($record) {
                                        return $record->amount;
                                    });

                                $negatives_budget += $negative_budget;
                            }
                            else
                            {
                                $negative_budget = 0;
                            }
                        @endphp

                        <tr>
                            <td> @if(isset($positive)) {{ $positive->name }} @endif </td>
                            <td>
                                @if(isset($positive) && $positive_amount > 0)
                                    +{{ number_format($positive_amount / 100, 2) }}

                                    @if($positive_amount > $positive_budget)
                                        <span class="label bg-green-jungle bg-font-green-jungle">
                                            <i class="fa fa-thumbs-o-up"></i>
                                        </span>
                                    @endif
                                @endif

                                @if($positive_amount < $positive_budget)
                                    <span class="label bg-red-thunderbird bg-font-red-thunderbird">
                                        <i class="fa fa-warning"></i>
                                    </span>
                                @endif
                            </td>
                            <td> @if(isset($positive) && $positive_budget > 0) +{{ number_format($positive_budget / 100, 2) }} @endif </td>

                            <td @if($negative->id == \App\BudgetPutAsidePlan::PUTSIDE_CATEGORY_ID) class="bg-blue-sharp bg-font-blue-sharp" @endif>
                                @if(isset($negative)) {{ $negative->name }} @endif
                            </td>
                            <td @if($negative->id == \App\BudgetPutAsidePlan::PUTSIDE_CATEGORY_ID) class="bg-blue-sharp bg-font-blue-sharp" @endif>
                                @if(isset($negative) && $negative_amount > 0)
                                    -{{ number_format($negative_amount / 100, 2) }}

                                    @if($negative->id == \App\BudgetPutAsidePlan::PUTSIDE_CATEGORY_ID && $negative_amount < $negative_budget)
                                        <span class="label bg-yellow-gold bg-font-yellow-gold">
                                            <i class="fa fa-warning"></i>
                                        </span>
                                    @endif

                                    @if($negative_amount > $negative_budget)
                                        <span class="label bg-red-thunderbird bg-font-red-thunderbird">
                                            <i class="fa fa-thumbs-o-down"></i>
                                        </span>
                                    @endif
                                @endif
                            </td>
                            <td @if($negative->id == \App\BudgetPutAsidePlan::PUTSIDE_CATEGORY_ID) class="bg-blue-sharp bg-font-blue-sharp" @endif>
                                @if(isset($negative) && $negative_budget > 0) -{{ number_format($negative_budget / 100, 2) }} @endif
                            </td>
                        </tr>
                    @endwhile

                        <tr class="bg-grey-salsa bg-font-grey-salsa">
                            <td> &nbsp; </td>
                            <td>
                                +{{ number_format($positives_sum / 100, 2) }}

                                @if($positives_sum > $positives_budget)
                                    <span class="label bg-green-jungle bg-font-green-jungle">
                                        <i class="fa fa-thumbs-o-up"></i>
                                    </span>
                                @else()
                                    <span class="label bg-red-thunderbird bg-font-red-thunderbird">
                                        <i class="fa fa-thumbs-o-down"></i>
                                    </span>
                                @endif
                            </td>
                            <td> +{{ number_format($positives_budget / 100, 2) }} </td>
                            <td> &nbsp; </td>
                            <td>
                                -{{ number_format($negatives_sum / 100, 2) }}

                                @if($negatives_sum < $negatives_budget)
                                    <span class="label bg-green-jungle bg-font-green-jungle">
                                        <i class="fa fa-thumbs-o-up"></i>
                                    </span>
                                @else()
                                    <span class="label bg-red-thunderbird bg-font-red-thunderbird">
                                        <i class="fa fa-thumbs-o-down"></i>
                                    </span>
                                @endif
                            </td>
                            <td> -{{ number_format($negatives_budget / 100, 2) }} </td>
                        </tr>

                    </tbody>
                </table>

                <blockquote>
                    <p>
                        Monthly balance:
                        @if($positives_sum - $negatives_sum >= 0)
                            <span class="font-green-jungle"><b>+{{ number_format(($positives_sum - $negatives_sum) / 100, 2) }}</b></span>
                            <span class="label bg-green-jungle bg-font-green-jungle">
                                <i class="fa fa-thumbs-o-up"></i>
                            </span>
                        @else
                            <span class="font-red-thunderbird"><b>{{ number_format(($positives_sum - $negatives_sum) / 100, 2) }}</b></span>
                            <span class="label bg-red-thunderbird bg-font-red-thunderbird">
                                <i class="fa fa-thumbs-o-down"></i>
                            </span>
                        @endif
                    </p>
                </blockquote>

            </div>

        </div>
    </div>

@endsection
