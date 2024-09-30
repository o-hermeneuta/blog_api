<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Models\Article;
use App\Enum\ArticleStatusEnum;

class ArticleService
{
    protected static $query;

    public static function tagList($tagName) {
        $article = new Article();
        self::$query = \DB::table($article->getTable() . ' as a')->select('a.id', 'a.background', 'a.title', 'a.slug', 'a.author', 'a.positive_reaction')
        ->join('tag_article as ta', 'a.id', '=', 'ta.article_id')
        ->join('tags as t', 'ta.tag_id', '=', 't.id')
        ->where('t.name', $tagName)
        ->orderBy('a.created_at', 'desc');
        return new static();
    }

    public static function postList() {
        $article = new Article();
        self::$query = \DB::table($article->getTable())->select('id', 'background', 'title', 'slug', 'author', 'positive_reaction')->orderBy('created_at', 'desc');
        return new static();
    }

    public static function resumeList() {
        $article = new Article();
        self::$query = \DB::table($article_tables)->select('id', 'title', 'slug')->orderBy('positive_reaction', 'desc');
        return new static();
    }

    public function paginate($page, $quantity, $where = null) {
        if ($page < 1) $page = 1;
        if ($quantity < 1) $quantity = 1;
        if (!is_null($where)) self::$query->where($where['field'], $where['value']);
        $offset = ($page - 1) * $quantity;
        $total = self::$query->count();
        $items = self::$query->skip($offset)->take($quantity)->get()->toArray();
        return [
            "items" => $items,
            "total" => $total,
            "total_pages" => (int) ceil($total / $quantity),
            "next" => $page + 1,
            "previous" => $page - 1 <= 1 ? 1 : $page - 1
        ];
    }
}
