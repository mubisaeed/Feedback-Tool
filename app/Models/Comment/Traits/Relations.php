<?php

namespace App\Models\Comment\Traits;

use App\Models\Feedback\Feedback;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait Relations
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function feedback(): BelongsTo
    {
        return $this->belongsto(Feedback::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsto(User::class);
    }
}
