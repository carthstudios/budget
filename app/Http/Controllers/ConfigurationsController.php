<?php

namespace App\Http\Controllers;

use App\BudgetMonthlyPlan;
use App\BudgetPutAsidePlan;
use App\Category;
use App\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConfigurationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function view(Request $request)
    {
        $budgets    = BudgetMonthlyPlan::where('family_id', Auth::user()->family_id)->get();

        $categories = Category::orderBy('is_positive')->orderBy('name')->get()
            ->each(function (&$category) use ($budgets) {
                if ($budgets->where('category_id', $category->id)->count() > 0)
                {
                    $category->amount             = intval($budgets->where('category_id', $category->id)->first()->amount);
                    $category->comment            = $budgets->where('category_id', $category->id)->first()->comment;
                }

                $category->records_count = Record::where('category_id', $category->id)->get()->count() + $budgets->where('category_id', $category->id)->count();
            });

        $putAsides = BudgetPutAsidePlan::where('family_id', Auth::user()->family_id)->get();

        return view('configurations', ['categories'   => $categories,
                                             'putAsides'    => $putAsides]);
    }

    public function category_edit(Request $request, int $category_id)
    {
        $category = Category::find($category_id);

        if (empty($category))
        {
            return redirect()->back()->withErrors(['Was not able to edit the category!']);
        }

        $category->is_positive  = $request->get('is_positive') == "true";
        $category->name         = $request->get('name');
        $category->save();

        return redirect()->back()->with('success', "Category updated!");
    }

    public function category_add(Request $request)
    {
        if (strlen($request->input('name')) < 3)
        {
            return redirect()->back()->withErrors(['The provided name is too short']);
        }

        $category = new Category;

        $category->name         = $request->input('name');
        $category->is_positive  = $request->input('is_positive') == "true";

        $category->save();

        return redirect()->back()->with('success', "Category created!");
    }

    public function category_remove(Request $request, int $category_id)
    {
        if (Record::where('category_id', $category_id)->count() > 0 || BudgetMonthlyPlan::where('category_id', $category_id)->count() > 0)
        {
            return redirect()->back()->withErrors(['This category cannot be deleted, as there are records recorded to it!']);
        }

        $category = Category::find($category_id);
        $category->delete();

        return redirect()->back()->with('success', "Category deleted!");
    }

    public function budget_update(Request $request, int $category_id)
    {
        $amount         = intval(floatval($request->get('amount')) * 100);
        $comment        = $request->get('comment');

        $monthly_budget = BudgetMonthlyPlan::where('family_id', Auth::user()->family_id)->where('category_id', $category_id)->first();

        // Create new
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

        // Delete
        if ($amount == 0 && strlen($comment) == 0)
        {
            $monthly_budget->delete();
            return redirect()->back()->with('success', "Monthly plan removed!");
        }

        // Update existing
        $monthly_budget->amount     = $amount;
        $monthly_budget->comment    = $comment;
        $monthly_budget->save();

        return redirect()->back()->with('success', "Monthly plan updated!");
    }

    public function putaside_add(Request $request)
    {
        $putAside = new BudgetPutAsidePlan;
        $putAside->amount       = floatval($request->get('amount')) * 100;
        $putAside->comment      = $request->get('comment');
        $putAside->category_id  = $request->get('category_id');
        $putAside->family_id    = Auth::user()->family_id;
        $putAside->save();

        $this->update_monthly_budget_for_putaside();

        return redirect()->back()->with('success', "Put aside plan added!");
    }

    public function putaside_edit(Request $request, int $putAside_id)
    {
        $putAside = BudgetPutAsidePlan::find($putAside_id);

        if (empty($putAside))
        {
            return redirect()->back()->withErrors(['Was not able to update put aside plan!']);
        }

        $putAside->amount       = floatval($request->get('amount')) * 100;
        $putAside->comment      = $request->get('comment');
        $putAside->category_id  = $request->get('category_id');
        $putAside->save();

        $this->update_monthly_budget_for_putaside();

        return redirect()->back()->with('success', "Put aside plan updated!");
    }

    public function putaside_remove(Request $request, int $putAside_id)
    {
        $putAside = BudgetPutAsidePlan::find($putAside_id);

        if (empty($putAside))
        {
            return redirect()->back()->withErrors(['Was not able to find the put aside plan to delete!']);
        }

        $putAside->delete();

        $this->update_monthly_budget_for_putaside();

        return redirect()->back()->with('success', "Put aside plan removed!");
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
