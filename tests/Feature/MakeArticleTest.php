<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Article;
use Tests\TestCase;

class MakeArticleTest extends TestCase
{
    use RefreshDatabase;

    public function test_try_make_article_without_title(): void
    {
        $response = $this->post('/article',[
            "background" => 'www.google.com',
            "author" => 'O Hermeneuta',
            "content" => 'arquivo de teste 123'
        ]);
        $response->assertSessionHasErrors([
            'title' => 'O campo título é obrigatório.'
        ]);
    }

    public function test_try_make_article_with_existing_title(): void
    {
        Article::create([
            'title' => 'Título Existente',
            'background' => 'www.example.com',
            "slug" => 'the-test',
            "author" => 'Tester',
            "content" => 'This is a Test',
            "positive_reaction" => 12,
            "status" => 'C',
            "in_carrousel" => false
        ]);

        $response = $this->post('/article',[
            'title' => 'Título Existente',
            "background" => 'www.google.com',
            "author" => 'O Hermeneuta',
            "content" => 'arquivo de teste 123'
        ]);
        $response->assertSessionHasErrors([
            'title' => 'O título já existe, por favor escolha outro.'
        ]);
    }

    public function test_try_make_article_with_existing_title_change_camel_case(): void
    {
        Article::create([
            'title' => 'Titulo Existente',
            'background' => 'www.example.com',
            "slug" => 'titulo-existente',
            "author" => 'Tester',
            "content" => 'This is a Test',
            "positive_reaction" => 12,
            "status" => 'C',
            "in_carrousel" => false
        ]);

        $response = $this->post('/article',[
            'title' => 'titulo existente',
            "background" => 'www.google.com',
            "author" => 'O Hermeneuta',
            "content" => 'arquivo de teste 123'
        ]);
        $response->assertSessionHas('error', 'O título já existe, por favor escolha outro.');
    }

    public function test_make_article_with_title(): void
    {
        $response = $this->post('/article',[
            "background" => 'www.google.com',
            "title" => "Artigo Teste",
            "author" => 'O Hermeneuta',
            "content" => 'arquivo de teste 123'
        ]);
        $response->assertSessionHas('success', 'Artigo criado com sucesso.');
    }
}
