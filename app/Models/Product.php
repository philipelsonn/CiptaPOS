<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $timestamp = true;
    protected $guarded = [];

    public function productCategory(): HasOne
    {
        return $this->hasOne(ProductCategory::class, 'id', 'category_id');
    }

    public function transactionDetails(): HasMany
    {
        return $this->hasMany(TransactionDetail::class, 'product_id');
    }

    public function supplierPricing(): BelongsTo
    {
        return $this->BelongsTo(supplierPricing::class);
    }
    public function stockout(): HasMany
    {
        return $this->hasMany(Stockout::class);
    }
}
