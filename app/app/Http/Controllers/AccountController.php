<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = auth()->user()
                    ->accounts()
                    ->orderBy('account_number')
                    ->get();

        return response()->json($accounts);
        
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'account_number' => [
            'required',
            'string',
            'max:20',
            Rule::unique('accounts')
        ->where(fn ($query) => $query->where('user_id', auth()->id())),
        ],
        'account_name' => ['required', 'string', 'max:255'],
        'account_type' => ['required', 'in:Asset,Liability,Equity,Revenue,Expense'],
        'parent_id' => [
            'nullable',
            Rule::exists('accounts', 'id')
        ->where(fn ($query) => $query->where('user_id', auth()->id())),
        ],
        'description' => ['nullable', 'string'],
        'is_active' => ['nullable', 'boolean'],
    ]);

    $validated['user_id'] = auth()->id();

    $account = Account::create($validated);

    return response()->json($account, 201);
}
}
