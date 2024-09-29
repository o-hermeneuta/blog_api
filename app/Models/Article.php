<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Article extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        "background",
        "title",
        "slug",
        "author",
        "content",
        "positive_reaction",
        "status",
        "in_carrousel"
    ];




}
