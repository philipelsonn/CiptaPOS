<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentMethod extends Model
{
    use HasFactory;
    protected $table = 'payment_methods';
    protected $primaryKey = 'id';
    protected $timestamp = true;
    protected $guarded = [];

    public function transactionHeader(): HasMany
    {
        return $this->hasMany(TransactionHeader::class);
    }
}




