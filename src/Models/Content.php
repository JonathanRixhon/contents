<?php

namespace Jonathanrixhon\Contents\Models;

use Spatie\EloquentSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Content extends Model  implements Sortable
{
    use SortableTrait, HasFactory, HasUuids;

    public $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];

    public $casts = [
        'content' => 'json',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'contenteable_id',
        'contenteable_type',
        'visible',
        'order',
        'component',
        'content',
    ];

    public function buildSortQuery()
    {
        return static::query()
            ->where('contenteable_id', $this->contenteable_id)
            ->where('contenteable_type', $this->contenteable_type);
    }
}
