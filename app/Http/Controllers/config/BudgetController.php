<?php

namespace App\Http\Controllers\Config;

use App\BudgetMonthlyPlan;
use App\BudgetPutAsidePlan;
use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function view(Request $request)
    {
        return view('config.budget');
    }

    public function monthly_update(Request $request)
    {
        $category_id    = $request->get('category_id');
        $amount         = intval(floatval($request->get('amount')) * 100);
        $comment        = $request->get('comment');

        $monthly_budget = BudgetMonthlyPlan::where('family_id', Auth::user()->family_id)
                            ->where('category_id', $category_id)->first();

        if (empty($monthly_budget))
        {
            $monthly_budget = new BudgetMonthlyPlan;

            $monthly_budget->category_id    = $category_id;
            $monthly_budget->family_id      = Auth::user()->family_id;
            $monthly_budget->amount         = $amount;
            $monthly_budget->comment        = $comment;
            $monthly_budget->save();

            return redirect()->back()->with('success', "Monthly plan created!");
        }

        if ($amount == 0 && strlen($comment) == 0)
        {
            $monthly_budget->delete();
            return redirect()->back()->with('success', "Monthly plan removed!");
        }

        $monthly_budget->amount     = $amount;
        $monthly_budget->comment    = $comment;
        $monthly_budget->save();

        return redirect()->back()->with('success', "Monthly plan updated!");
    }

    public function put_aside_update(Request $request)
    {
        $putAside_id    = $request->get('putaside_id');
        $category_id    = $request->get('category_id');
        $amount         = intval(floatval($request->get('amount')) * 100);
        $comment        = $request->get('comment');

        $putAside = BudgetPutAsidePlan::find($putAside_id);

        if (empty($putAside))
        {
            return redirect()->back()->withErrors(['Was not able to update put aside plan!']);
        }

        $putAside->amount       = $amount;
        $putAside->comment      = $comment;
        $putAside->category_id  = $category_id;
        $putAside->save();

        $this->update_monthly_budget_for_putaside();

        return redirect()->back()->with('success', "Put aside plan updated!");
    }

    public function put_aside_remove(Request $request, $record_id)
    {
        $putAside = BudgetPutAsidePlan::find($record_id);

        if (empty($putAside))
        {
            return redirect()->back()->withErrors(['Was not able to find the put aside plan to delete!']);
        }

        $putAside->delete();

        $this->update_monthly_budget_for_putaside();

        return redirect()->back()->with('success', "Put aside plan removed!");
    }

    public function put_aside_add(Request $request)
    {
        $putAside = new BudgetPutAsidePlan;
        $putAside->amount       = intval(floatval($request->get('amount')) * 100);
        $putAside->comment      = $request->get('comment');
        $putAside->category_id  = $request->get('category_id');
        $putAside->family_id    = Auth::user()->family_id;
        $putAside->save();

        $this->update_monthly_budget_for_putaside();

        return redirect()->back()->with('success', "Put aside plan added!");
    }

    private function update_monthly_budget_for_putaside()
    {
        // Calculate monthly share to put aside
        $sum = 0;
        foreach(BudgetPutAsidePlan::where('family_id', Auth::user()->family_id)->get() as $budget_putaside)
        {
            $sum += $budget_putaside->amount / 12;
        }

        // Update record in the monthly budget
        $putaside_monthly_budget = BudgetMonthlyPlan::where('category_id', BudgetPutAsidePlan::PUTSIDE_CATEGORY_ID)->where('family_id', Auth::user()->family_id)->first();

        if(empty($putaside_monthly_budget))
        {
            $new_budget_record = new BudgetMonthlyPlan;

            $new_budget_record->family_id   = Auth::user()->family_id;
            $new_budget_record->category_id = BudgetPutAsidePlan::PUTSIDE_CATEGORY_ID;
            $new_budget_record->comment     = "Automatically updated";
            $new_budget_record->amount      = $sum;

            $new_budget_record->save();
        }
        else
        {
            $putaside_monthly_budget->amount = $sum;
            $putaside_monthly_budget->save();
        }
    }
}
