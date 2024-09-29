<?php

namespace App\Repositories;

use App\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class Repository implements RepositoryInterface
{

    protected static $model;

    public static function successBody(string $message):array {
        return ['status' => 'success', 'status_number' => 200 , 'value' => $message];
    }

    public static function errorBody(string $message):array {
        return ['status' => 'error', 'status_number' => 500 , 'value' => $message];
    }

    public static function getModel(): Model {
        return app(static::$model);
    }

    public static function create($body) {
        return self::getModel()::create($body);
    }

    public static function delete(string $id) {
        return self::getModel()::query()->findOrFail($id)->delete();
    }

    public static function update(string $id, $body) {
        return self::getModel()::query()->findOrFail($id)->update($body);
    }

    public static function read(string $id): Model {
        return self::getModel()::query()->findOrFail($id);
    }
}
