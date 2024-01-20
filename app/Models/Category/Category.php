<?php

namespace App\Models\Category;

use App\Models\Category\Traits\Relations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static \Database\Factories\Category\CategoryFactory factory($count = null, $state = []) */
class Category extends Model
{
    use HasFactory, Relations;
    protected $fillable = [
        'name'
    ];
}
