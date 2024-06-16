<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PaymentMethod extends Model
{
    use HasFactory;
    protected $table = 'payment_methods';
    protected $primaryKey = 'id';
    protected $timestamp = true;
    protected $guarded = [];

    public function transactionHeader(): BelongsToMany
    {
        return $this->belongsToMany(TransactionHeader::class);
    }
}




