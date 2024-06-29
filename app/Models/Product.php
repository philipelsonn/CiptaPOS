<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $timestamp = true;
    protected $guarded = [];

    public function productCategory(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function transactionDetail(): HasMany
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function supplierPricing(): HasMany
    {
        return $this->hasMany(supplierPricing::class);
    }
    public function stockout(): HasMany
    {
        return $this->hasMany(Stockout::class);
    }
}
