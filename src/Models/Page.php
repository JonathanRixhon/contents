<?php

namespace Jonathanrixhon\Contents\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jonathanrixhon\Contents\Models\Concerns\HasContents;

class Page extends Model
{
    use HasFactory, HasUuids, HasContents;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'route',
        'meta_description',
        'meta_og',
        'meta_twitter',
    ];
}
