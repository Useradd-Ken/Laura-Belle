<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::orderBy('account_number')->get();

        return response()->json($accounts);
        
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_number' => ['required', 'string', 'max:20', 'unique:accounts,account_number'],
            'account_name' => ['required', 'string', 'max:255'],
            'account_type' => ['required', 'in:Asset,Liability,Equity,Revenue,Expense'],
            'parent_id' => ['nullable', 'exists:accounts,id'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $account = Account::create($validated);

        return response()->json($account, 201);
    }
}
