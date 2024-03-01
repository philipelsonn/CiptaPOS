<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;
    protected $table = 'suppliers';
    protected $primaryKey = 'id';
    protected $timestamp = true;
    protected $guarded = [];

    public function supplierPricing(): HasMany
    {
        return $this->hasMany(SupplierPricing::class);
    }
}
