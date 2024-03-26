<?php

namespace Jonathanrixhon\Contents\Models\Concerns;

use Jonathanrixhon\Contents\Models\Content;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasContents
{
    /**
     * Get all of the model's contents.
     */
    public function contents(): MorphMany
    {
        return $this->morphMany(Content::class, 'contenteable');
    }
}
