<?php

namespace App\Interfaces;
use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    public static function getModel(): Model;
    public static function create($body);
    public static function delete(string $id);
    public static function update(string $id, $body);
    public static function read(string $id): Model;
}
