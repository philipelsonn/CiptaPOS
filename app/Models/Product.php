<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $timestamp = true;
    protected $guarded = [];

    public function productCategory(): HasOne
    {
        return $this->hasOne(ProductCategory::class);
    }

    public function transactionDetail(): BelongsTo
    {
        return $this->belongsTo(TransactionDetail::class);
    }

    public function supplierPricing(): BelongsTo
    {
        return $this->BelongsTo(supplierPricing::class);
    }
}
