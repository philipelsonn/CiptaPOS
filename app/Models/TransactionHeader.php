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
    protected $table = 'transaction_headers';
    protected $primaryKey = 'id';
    protected $timestamp = true;
    protected $guarded = [];

    public function paymentMethod(): HasOne
    {
        return $this->hasOne(PaymentMethod::class, 'id', 'payment_method_id');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cashier_id', 'id');
    }

    public function transactionDetails(): HasMany
    {
        return $this->hasMany(TransactionDetail::class, 'transaction_header_id', 'id');
    }

    public function calculateTotalPrice()
    {
        return $this->transactionDetails->sum(function ($detail) {
            return $detail->quantity * $detail->price;
        });
    }
}
