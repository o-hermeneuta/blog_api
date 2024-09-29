<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Article;

class RateArticleTest extends TestCase
{
    use RefreshDatabase;

    protected $article;

    public function setUp():void {
        parent::setUp();
        $this->article = Article::create([
            "background" => 'www.gg.com',
            "title" => 'The Test',
            "slug" => 'the-test',
            "author" => 'Tester',
            "content" => 'This is a Test',
            "positive_reaction" => 12,
            "status" => 'C',
            "in_carrousel" => false
        ]);
    }

    public function test_rate_with_no_id(): void
    {
        $response = $this->patch('article/a8ed0879-0c96-49bb-9dca-5598e94b04b7/rate');
        $response->assertSessionHas('error', 'Artigo não foi encontrado.');
    }

    public function test_rate_with_valid_id(): void
    {
        $response = $this->patch('article/' . $this->article->id . '/rate');
        $response->assertSessionHas('success', 'Artigo ganhou nova avaliação.');
    }
}
