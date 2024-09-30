<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Article;
use App\Models\Tag;
use Tests\TestCase;

class RemoveTagOnArticleTest extends TestCase
{
    use RefreshDatabase;

    public function test_remove_and_delete_tag(): void
    {
        $article = Article::create([
            'title' => 'Titulo Teste',
            'background' => 'www.example.com',
            "slug" => 'titulo-teste',
            "author" => 'Tester',
            "content" => 'This is a Test',
            "positive_reaction" => 0,
            "status" => 'C',
            "in_carrousel" => false
        ]);
        $tag = Tag::create([
            'name' => 'teste'
        ]);
        $article->tags()->syncWithoutDetaching($tag->id);
        $this->assertTrue($article->tags->contains('name', 'teste'));
        $response = $this->delete('/tag/' . $article->id, ["name" => 'teste']);
        $article->refresh();
        $this->assertFalse($article->tags()->where('name', 'teste')->exists());
        $this->assertDatabaseMissing('tags', ['name' => $tag->name]);
        $response->assertSessionHas('success', 'Artigo perdeu uma tag.');
    }

    public function test_remove_tag(): void
    {
        $article = Article::create([
            'title' => 'Titulo Teste',
            'background' => 'www.example.com',
            "slug" => 'titulo-teste',
            "author" => 'Tester',
            "content" => 'This is a Test',
            "positive_reaction" => 0,
            "status" => 'C',
            "in_carrousel" => false
        ]);
        $article_two = Article::create([
            'title' => 'Titulo Dois Teste',
            'background' => 'www.example.com',
            "slug" => 'titulo-dois-teste',
            "author" => 'Tester',
            "content" => 'This is a Test',
            "positive_reaction" => 0,
            "status" => 'C',
            "in_carrousel" => false
        ]);
        $tag = Tag::create([
            'name' => 'teste'
        ]);
        $article->tags()->syncWithoutDetaching($tag->id);
        $article_two->tags()->syncWithoutDetaching($tag->id);
        $this->assertTrue($article->tags->contains('name', 'teste'));
        $this->assertTrue($article_two->tags->contains('name', 'teste'));
        $response = $this->delete('/tag/' . $article->id, ["name" => 'teste']);
        $article->refresh();
        $this->assertFalse($article->tags()->where('name', 'teste')->exists(), 'A tag ainda está associada ao artigo.');
        $this->assertDatabaseHas('tags', ['name' => $tag->name]);
        $response->assertSessionHas('success', 'Artigo perdeu uma tag.');
    }

    public function test_connect_invalid_article(): void
    {
        $tag = Tag::create([
            'name' => 'teste'
        ]);
        $response = $this->delete('/tag/a8ed0879-0c96-49bb-9dca-5598e94b04b7', ["name" => 'teste']);
        $response->assertSessionHas('error', 'Erro ao remover.');
    }
}
