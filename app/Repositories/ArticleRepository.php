<?php

namespace App\Repositories;

use Illuminate\Support\Str;
use App\Models\Article;
use App\Interfaces\RepositoryInterface;
use App\Enum\ArticleStatusEnum;

class ArticleRepository extends Repository
{
    protected static $model = Article::class;

    public static function create($body) {
        try {
            $body["slug"] = Str::slug($body["title"]);
            $article = parent::create($body);
            parent::$success_body['value'] = 'Artigo criado com sucesso.';
            return parent::$success_body;
        } catch (\Throwable $th) {
            parent::$error_body['value'] = 'O título já existe, por favor escolha outro.';
            return parent::$error_body;
        }
    }

    public static function delete($id): array {
        try {
            parent::delete($id);
            parent::$success_body['value'] = 'Article removed.';
            return parent::$success_body;
        } catch (\Throwable $th) {
            parent::$error_body['value'] = 'Article not found.';
            return parent::$error_body;
        }
    }

    public static function post($id): array {
        try {
            parent::update($id, ['status' => ArticleStatusEnum::Posted]);
            parent::$success_body['value'] = 'Article posted.';
            return parent::$success_body;
        } catch (\Throwable $th) {
            parent::$error_body['value'] = 'Article not found.';
            return parent::$error_body;
        }
    }

    public static function hide($id): array {
        try {
            parent::update($id, ['status' => ArticleStatusEnum::Created]);
            parent::$success_body['value'] = 'Article not posted anymore.';
            return parent::$success_body;
        } catch (\Throwable $th) {
            parent::$error_body['value'] = 'Article not found.';
            return parent::$error_body;
        }
    }

    public static function rate($id): array {
        try {
            $article = parent::read($id, ['status' => ArticleStatusEnum::Created]);
            $article->update(['positive_reaction' => $article->positive_reaction + 1]);
            parent::$success_body['value'] = 'Article gain new rate.';
            return parent::$success_body;
        } catch (\Throwable $th) {
            parent::$error_body['value'] = 'Article not found.';
            return parent::$error_body;
        }
    }
}
