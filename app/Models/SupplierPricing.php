<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupplierPricing extends Model
{
    use HasFactory;
    protected $table = 'supplier_pricings';
    protected $primaryKey = 'id';
    protected $timestamp = true;
    protected $guarded = [];

    public function product(): HasOne
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function supplierTransaction(): BelongsTo
    {
        return $this->belongsTo(SupplierTransaction::class);
    }
}
