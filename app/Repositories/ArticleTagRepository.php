<?php

namespace App\Repositories;

class ArticleTagRepository extends Repository
{
    protected static $model = Article::class;

    public static function putTag($id, $tagName) {
        try {
            $tag = TagRepository::findByName($tagName);
            if(is_null($tag)) {$tag = TagRepository::create($tagName);}
            $article = ArticleRepository::read($id);
            $article->tags()->syncWithoutDetaching($tag->id);
            return parent::successBody('Artigo ganhou nova tag.');
        } catch (\Throwable $th) {
            return parent::errorBody('Erro ao conectar.');
        }
    }

    public static function removeTag($id, $tagName) {
        try {
            $tag = TagRepository::findByName($tagName);
            $article = ArticleRepository::read($id);
            $article->tags()->detach($tag->id);
            if(!$tag->articles()->exists()) {$tag->delete();}
            return parent::successBody('Artigo perdeu uma tag.');
        } catch (\Throwable $th) {
            return parent::errorBody('Erro ao remover.');
        }
    }
}
