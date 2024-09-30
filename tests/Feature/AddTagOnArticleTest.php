<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Article;
use App\Models\Tag;
use Tests\TestCase;

class AddTagOnArticleTest extends TestCase
{
    use RefreshDatabase;

    public function test_connect_new_tag(): void
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
        $response = $this->patch('/tag/' . $article->id, ["name" => 'teste']);
        $article->refresh();
        $this->assertTrue($article->tags->contains('name', 'teste'));
        $response->assertSessionHas('success', 'Artigo ganhou nova tag.');
    }

    public function test_connect_existing_tag(): void
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
        $response = $this->patch('/tag/' . $article->id, ["name" =>$tag->name]);
        $article->refresh();
        $this->assertTrue($article->tags->contains('name', 'teste'));
        $response->assertSessionHas('success', 'Artigo ganhou nova tag.');
    }

    public function test_connect_invalid_article(): void
    {
        $tag = Tag::create([
            'name' => 'teste'
        ]);
        $response = $this->patch('/tag/a8ed0879-0c96-49bb-9dca-5598e94b04b7', ["name" =>$tag->name]);
        $response->assertSessionHas('error', 'Erro ao conectar.');
    }
}
