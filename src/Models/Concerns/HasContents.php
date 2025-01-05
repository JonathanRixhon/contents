<?php

namespace Jonathanrixhon\Contents\Models\Concerns;

use Jonathanrixhon\Contents\Models\Content;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasContents
{
    public static string $contentClass = Content::class;
    
    /**
     * Get all of the model's contents.
     */
    public function contents(): MorphMany
    {
        return $this->morphMany(static::$contentClass, 'contenteable');
    }
}
