<?php

namespace App\Repositories;

use Illuminate\Support\Str;
use App\Models\Article;
use App\Enum\ArticleStatusEnum;

class ArticleRepository extends Repository
{
    protected static $model = Article::class;

    public static function create($body) {
        try {
            $body["slug"] = Str::slug($body["title"]);
            $article = parent::create($body);
            return parent::successBody('Artigo criado com sucesso.');
        } catch (\Throwable $th) {
            return parent::errorBody('O título já existe, por favor escolha outro.');
        }
    }

    public static function delete($id): array {
        try {
            parent::delete($id);
            return parent::successBody('Article removed.');
        } catch (\Throwable $th) {
            return parent::errorBody('Article not found.');
        }
    }

    public static function post($id): array {
        try {
            parent::update($id, ['status' => ArticleStatusEnum::Posted]);
            return parent::successBody('Article posted.');
        } catch (\Throwable $th) {
            return parent::errorBody('Article not found.');
        }
    }

    public static function hide($id): array {
        try {
            parent::update($id, ['status' => ArticleStatusEnum::Created]);
            return parent::successBody('Article not posted anymore.');
        } catch (\Throwable $th) {
            return parent::errorBody('Article not found.');
        }
    }

    public static function rate($id): array {
        try {
            $article = parent::read($id, ['status' => ArticleStatusEnum::Created]);
            $article->update(['positive_reaction' => $article->positive_reaction + 1]);
            return parent::successBody('Article gain new rate.');
        } catch (\Throwable $th) {
            return parent::errorBody('Article not found.');
        }
    }
}
