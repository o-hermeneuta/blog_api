<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        "name"
    ];

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'tag_article', 'tag_id', 'article_id');
    }
}
