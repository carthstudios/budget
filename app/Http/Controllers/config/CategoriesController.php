<?php

namespace App\Http\Controllers\Config;

use App\BudgetMonthlyPlan;
use App\BudgetPutAsidePlan;
use App\Category;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function view(Request $request)
    {
        return view('config.categories');
    }

    public function remove(Request $request, int $id)
    {
        if (\App\Record::where('category_id', $id)->get()->count() > 0)
        {
            return redirect()->back()->withErrors(['This category cannot be deleted, as there are records recorded to it!']);
        }

        $category = Category::find($id);
        $category->delete();

        return redirect()->back()->with('success', "Category deleted!");
    }

    public function edit(Request $request, int $id)
    {
        $category = Category::find($id);

        if (empty($category))
        {
            return redirect()->back()->withErrors(['Was not able to edit the category!']);
        }

        $category->is_positive = $request->get('is_positive') == "true";
        $category->name = $request->get('name');
        $category->save();

        return redirect()->back()->with('success', "Category updated!");
    }

    public function add(Request $request)
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
}
