<?php

namespace App\Repositories;

use App\Models\Tag;
use Illuminate\Support\Str;

class TagRepository extends Repository
{
    protected static $model = Tag::class;

    public static function create($name) {
        return parent::create(['name' => Str::slug($name)]);
    }

    public static function findByName($name) {
         return self::getModel()::where('name', 'like', '%' . Str::slug($name) . '%')->first();
    }
}
