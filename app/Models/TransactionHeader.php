<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;



class TransactionHeader extends Model
{
    use HasFactory;
    protected $table = 'transaction_header';
    protected $primaryKey = 'id';
    protected $timestamp = true;
    protected $guarded = [];

    public function paymentMethod(): HasOne
    {
        return $this->hasOne(PaymentMethod::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactionDetail(): HasMany
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
