<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    //
    public function index()
    {
        return view('expenses.index');
    }

    public function store(Request $request)
    {
        // Validate required fields
        $validated = $request->validate([
            'guard_salary' => 'required|numeric|min:0',
            'electricity_bill' => 'required|numeric|min:0',
            'monjilG&GB' => 'required|numeric|min:0',
        ]);

        // Filter valid "other expenses" where both fields are filled
        $otherExpenses = [];
        $descriptions = $request->input('description', []);
        $amounts = $request->input('other_amount', []);

        foreach ($descriptions as $index => $desc) {
            $amount = $amounts[$index] ?? null;

            if (!empty($desc) && !empty($amount)) {
                $otherExpenses[] = [
                    'description' => $desc,
                    'amount' => $amount,
                ];
            }
        }

        // Create the expense record
        Expense::create([
            'guard_salary' => $validated['guard_salary'],
            'electricity_bill' => $validated['electricity_bill'],
            'monjil_gas_guard_bill' => $validated['monjilG&GB'],
            'other_expenses' => !empty($otherExpenses) ? $otherExpenses : null,
        ]);

        return redirect()->back()->with('success', 'Expense saved successfully!');
    }
}
