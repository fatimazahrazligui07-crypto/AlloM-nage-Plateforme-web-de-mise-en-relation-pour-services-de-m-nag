<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommissionRule;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CommissionRuleController extends Controller
{
   public function index()
{
    $rules = CommissionRule::orderBy('min_amount')->get();
    return Inertia::render('admin/CommissionRules', ['rules' => $rules]);
}

public function store(Request $request)
{
    $request->validate([
        'min_amount' => 'required|numeric',
        'max_amount' => 'required|numeric|gt:min_amount',
        'rate' => 'required|numeric|min:0|max:100',
    ]);
    CommissionRule::create($request->all());
    return redirect()->back()->with('success', 'Règle ajoutée');
}

   public function update(Request $request, $id)
{
    $request->validate([
        'min_amount' => 'required|numeric',
        'max_amount' => 'required|numeric|gt:min_amount',
        'rate' => 'required|numeric|min:0|max:100',
    ]);
    CommissionRule::findOrFail($id)->update($request->only(['min_amount', 'max_amount', 'rate']));
    return redirect()->back()->with('success', 'Règle modifiée');
}

    public function destroy($id)
    {
        CommissionRule::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Règle supprimée');
    }
}