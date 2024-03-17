<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SupplierTransaction extends Model
{
    use HasFactory;
    protected $table = 'supplier_transactions';
    protected $primaryKey = 'id';
    protected $timestamp = true;
    protected $guarded = [];

    public function supplierPricing(): HasOne
    {
        return $this->hasOne(SupplierPricing::class, 'id', 'supplier_price_id');
    }
}
