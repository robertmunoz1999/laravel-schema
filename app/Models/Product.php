<?php

namespace App\Models;

use App\Scopes\ProductScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    use ProductScopes;

    protected $fillable = [
        'name'
    ];
}
