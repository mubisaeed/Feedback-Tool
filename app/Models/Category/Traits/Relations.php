<?php

namespace App\Models\Category\Traits;

use App\Models\Feedback\Feedback;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait Relations
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function feedbacks(): HasMany
    {
        return $this->hasMany(Feedback::class);
    }
}
