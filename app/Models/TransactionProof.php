<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class TransactionProof extends Model
{
    
    protected $fillable = [
        'file_path',
        'user_id',
        'transaction_id',
    ];

    public function filePath(): Attribute
    {
        return Attribute::make(fn($value) => Storage::url($value));
    }


    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
