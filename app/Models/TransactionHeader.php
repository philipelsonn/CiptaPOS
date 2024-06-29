<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;



class TransactionHeader extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'transaction_headers';
    protected $primaryKey = 'id';
    protected $timestamp = true;
    protected $guarded = [];

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }

    public function transactionDetails(): HasMany
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function calculateTotalPrice()
    {
        return $this->transactionDetails->sum(function ($detail) {
            return $detail->quantity * $detail->price;
        });
    }
}
