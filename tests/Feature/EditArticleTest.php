<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Article;
use Tests\TestCase;

class EditArticleTest extends TestCase
{
    use RefreshDatabase;

    public function test_edit_invalid_values(): void
    {
        $article = Article::create([
            'title' => 'Titulo Existente',
            'background' => 'www.example.com',
            "slug" => 'titulo-existente',
            "author" => 'Tester',
            "content" => 'This is a Test',
            "positive_reaction" => 12,
            "status" => 'C',
            "in_carrousel" => false
        ]);
        $response = $this->put('/article/' . $article->id, [
            "background" => 12
        ]);
        $response->assertSessionHasErrors(['background']);
    }

    public function test_edit_invalid_article(): void
    {
        $response = $this->put('/article/a8ed0879-0c96-49bb-9dca-5598e94b04b7', [
            "background" => 'www.google.com',
            "title" => "Artigo Teste Editado",
            "author" => 'The Hermeneuta',
            "content" => 'arquivo de teste 321'
        ]);
        $response->assertSessionHas('error', 'Artigo não foi encontrado.');
    }

    public function test_edit_valid_article(): void
    {
        $article = Article::create([
            'title' => 'Titulo Existente',
            'background' => 'www.example.com',
            "slug" => 'titulo-existente',
            "author" => 'Tester',
            "content" => 'This is a Test',
            "positive_reaction" => 12,
            "status" => 'C',
            "in_carrousel" => false
        ]);
        $response = $this->put('/article/' . $article->id, [
            "background" => 'www.google.com',
            "title" => "Artigo Teste Editado",
            "author" => 'The Hermeneuta',
            "content" => 'arquivo de teste 321'
        ]);
        $article->refresh();
        $this->assertEquals("Artigo Teste Editado", $article->title);
        $response->assertSessionHas('success', 'Artigo atualizado com sucesso.');
    }
}
