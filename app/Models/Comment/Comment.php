<?php

namespace App\Models\Comment;

use App\Models\Comment\Traits\Relations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory, Relations;
    protected $fillable = [
        'feedback_id',
        'user_id',
        'content'
    ];
}
