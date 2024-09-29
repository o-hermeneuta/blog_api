<?php

namespace App\Repositories;

use App\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class Repository implements RepositoryInterface
{

    protected static $model;

    protected static $success_body = ['status' => 'success', 'status_number' => 200 , 'value' => ''];

    protected static $error_body = ['status' => 'error', 'status_number' => 500 , 'value' => ''];

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
