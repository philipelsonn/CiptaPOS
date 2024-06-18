<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function supplierTransaction(): BelongsToMany
    {
        return $this->belongsToMany(SupplierTransaction::class);
    }
}
