<?php

namespace App\Repositories;

use Illuminate\Support\Str;
use App\Models\Article;
use App\Enum\ArticleStatusEnum;
use App\Services\ArticleService;

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

    public static function update(string $id, $body) {
        try {
            parent::update($id, $body);
            return parent::successBody('Artigo atualizado com sucesso.');
        } catch (\Throwable $th) {
            return parent::errorBody('Artigo não foi encontrado.');
        }
    }

    public static function delete($id): array {
        try {
            parent::delete($id);
            return parent::successBody('Artigo foi removido.');
        } catch (\Throwable $th) {
            return parent::errorBody('Artigo não foi encontrado.');
        }
    }

    public static function post($id): array {
        try {
            parent::update($id, ['status' => ArticleStatusEnum::Posted]);
            return parent::successBody('Artigo postado.');
        } catch (\Throwable $th) {
            return parent::errorBody('Artigo não foi encontrado.');
        }
    }

    public static function hide($id): array {
        try {
            parent::update($id, ['status' => ArticleStatusEnum::Created]);
            return parent::successBody('Artigo não esta mais postado.');
        } catch (\Throwable $th) {
            return parent::errorBody('Artigo não foi encontrado.');
        }
    }

    public static function rate($id): array {
        try {
            $article = parent::read($id, ['status' => ArticleStatusEnum::Created]);
            $article->update(['positive_reaction' => $article->positive_reaction + 1]);
            return parent::successBody('Artigo ganhou nova avaliação.');
        } catch (\Throwable $th) {
            return parent::errorBody('Artigo não foi encontrado.');
        }
    }

    public static function list($page) {
        return ArticleService::postList()->paginate($page, 10);
    }

    public static function postedList($page) {
        return ArticleService::postList()->paginate($page, 10, ["field" => "status", "value" => 'P']);
    }

    public static function carrouselList($page) {
        return ArticleService::postList()->paginate($page, 10, ["field" => "in_carrousel", "value" => true]);
    }

    public static function listTopTen() {
        $items = ArticleService::resumeList()->take(10)->get()->toArray();
        return [ "items" => $items ];
    }

    public static function listTagPosts($page, $tagName) {
        return ArticleService::tagList($tagName)->paginate($page, 10, ["field" => "in_carrousel", "value" => true]);
    }
}
