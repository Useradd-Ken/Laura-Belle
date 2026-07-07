<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JournalEntry extends Model
{
    protected $fillable = [
        'user_id',
        'entry_date',
        'reference_no',
        'description',
        'status',
        'posted_at',
        'voided_at',
        'void_reason',
        'reversal_entry_id',
    ];

    /**
     * Owner of the journal entry.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Journal entry lines.
     */
    public function lines()
    {
        return $this->hasMany(JournalEntryLine::class);
    }

    /**
     * Reversing journal entry.
     */
    public function reversalEntry()
    {
        return $this->belongsTo(JournalEntry::class, 'reversal_entry_id');
    }

    /**
     * Original journal entry if this entry is a reversal.
     */
    public function originalEntry()
    {
        return $this->hasOne(JournalEntry::class, 'reversal_entry_id');
    }
}