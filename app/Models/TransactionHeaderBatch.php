<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;



class TransactionHeaderBatch extends Model
{
    use HasFactory;
    protected $connection = 'mysql_target';
    protected $table = 'transaction_headers';
    protected $primaryKey = 'id';
    protected $timestamp = true;
    protected $guarded = [];
}
