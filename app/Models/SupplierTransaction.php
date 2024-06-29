<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupplierTransaction extends Model
{
    use HasFactory;
    protected $table = 'supplier_transactions';
    protected $primaryKey = 'id';
    protected $timestamp = true;
    protected $guarded = [];

    public function supplierPricing(): BelongsTo
    {
        return $this->belongsTo(SupplierPricing::class, 'supplier_price_id');
    }
}
