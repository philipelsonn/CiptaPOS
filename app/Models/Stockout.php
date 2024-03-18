<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stockout extends Model
{
    protected $table = 'stockout';

    protected $fillable = [
        'product_id',
        'quantity',
        'description',
        'date',
    ];

    protected $dates = [
        'date',
        'created_at',
        'updated_at',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}