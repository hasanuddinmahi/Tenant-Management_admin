<?php
namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Apartment;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show the dashboard with total payments, total expenses, and the amount left.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Total amount paid in bookings (sum of price from apartments for paid bookings)
        $totalPayments = Booking::where('payment_status', 'paid')
            ->join('apartments', 'bookings.apartment_id', '=', 'apartments.id')
            ->sum('apartments.price');

        // Calculate the sum of all expenses: guard_salary, electricity_bill, monjil_gas_guard_bill
        $totalExpenses = Expense::select(DB::raw('SUM(guard_salary + electricity_bill + monjil_gas_guard_bill) as total_expenses'))
            ->get();  // Summing up the regular expenses

        // Initialize total expense from regular ones
        $totalExpensesAmount = $totalExpenses->sum('total_expenses');

        // Get all other_expenses and sum them up, ensuring they're numeric
        $otherExpenses = Expense::all()->pluck('other_expenses')->flatten();
        $totalOtherExpenses = $otherExpenses->filter(function ($value) {
            return is_numeric($value);  // Ensure the value is numeric
        })->sum();

        // Add the other expenses to the regular expenses
        $totalExpensesAmount += $totalOtherExpenses;

        // Calculate the amount left (totalPayments - totalExpenses)
        $amountLeft = $totalPayments - $totalExpensesAmount;

        // Pass the data to the view
        return view('welcome', compact('totalPayments', 'totalExpensesAmount', 'amountLeft'));
    }
}
