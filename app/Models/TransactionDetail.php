<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionDetail extends Model
{
    use HasFactory;
    protected $table = 'transaction_details';
    protected $primaryKey = 'id';
    protected $timestamp = true;
    protected $guarded = [];

    public function product(): BelongsTo
    {
        return $this->BelongsTo(Product::class);
    }

    public function transactionHeader(): BelongsTo
    {
        return $this->belongsTo(TransactionHeader::class, 'transaction_header_id');
    }
}
