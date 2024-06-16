<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductCategory extends Model
{
    use HasFactory;
    protected $table = 'product_categories';
    protected $primaryKey = 'id';
    protected $timestamp = true;
    protected $guarded = [];

    public function product(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_id', 'id');
    }
}
