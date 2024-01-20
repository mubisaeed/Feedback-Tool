<?php

namespace App\Models\Feedback;

use App\Models\Feedback\Traits\Relations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory, Relations;
    protected $table = 'feedbacks';
    protected $fillable = [
        'title',
        'description',
        'category_id',
        'user_id'
    ];

    /**
     * @return void
     */
    public static function boot(): void
    {
        parent::boot();
        self::creating(function (Feedback $feedback) {
            $feedback->user_id = auth()->user()->id;
        });
    }
}
