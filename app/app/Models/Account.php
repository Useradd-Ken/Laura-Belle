<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Account extends Model
{
    protected $fillable = [
        'user_id',
        'account_number',
        'account_name',
        'account_type',
        'parent_id',
        'description',
        'is_active',
    ];

    /**
     * Owner of the account
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Parent account
     */
    public function parent()
    {
        return $this->belongsTo(Account::class, 'parent_id');
    }

    /**
     * Child accounts
     */
    public function children()
    {
        return $this->hasMany(Account::class, 'parent_id');
    }

    /**
     * Journal entry lines that use this account
     */
    public function journalEntryLines()
    {
        return $this->hasMany(JournalEntryLine::class);
    }
}