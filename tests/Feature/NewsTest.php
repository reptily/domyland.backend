<?php

namespace Tests\Feature;

use App\Author;
use App\News;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NewsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Create news.
     *
     * @return void
     */
    public function testCreateNews()
    {
        $user = factory(User::class)->create();
        $author = factory(Author::class)->create();

        $responce = $this->actingAs($user, 'api')->post("/api/news", [
            'title' => 'Text title',
            'preview' => 'Preview',
            'body' => 'Body body body',
            'date' => '2020-04-01',
            'author_id' => $author->id,
            'image' => 'http://localhost/example.jpg'
        ]);

        $responce->assertStatus(201);
        $responce->assertJsonStructure([
            'id',
            'title',
            'preview',
            'body',
            'image',
            'date',
            'author' => [
                'id',
                'name',
            ]
        ]);
    }


    /**
     * List news
     */
    public function testIndex()
    {
        $author = factory(Author::class)->create();
        $news = array();
        for ($i = 0; $i <= 10; $i++) {
            $news[] = factory(News::class)->create([
                'author_id' => $author->id,
            ]);
        }

        $responce = $this->get("/api/news");

        $responce->assertStatus(200);
        $responce->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'title',
                    'preview',
                    'body',
                    'date',
                    'image',
                    'author' => [
                        'id',
                        'name',
                    ]
                ]
            ],
            'links' => [
                'last',
                'prev',
                'next',
            ],
            'meta' => [
                'current_page',
                'from',
                'last_page',
                'per_page',
                'to',
                'total',
            ]
        ]);
    }


    /**
     * Show one news
     */
    public function testShow()
    {
        $author = factory(Author::class)->create();
        $news = factory(News::class)->create([
            'author_id' => $author->id,
        ]);

        $responce = $this->get("/api/news/" . $news->id);

        $responce->assertStatus(200);
        $responce->assertJsonStructure([
            'id',
            'title',
            'preview',
            'body',
            'image',
            'date',
            'author' => [
                'id',
                'name',
            ]
        ]);
    }


    /**
     * Update news
     */
    public function testUpdate()
    {
        $user = factory(User::class)->create();
        $author = factory(Author::class)->create();
        $news = factory(News::class)->create([
            'author_id' => $author->id,
        ]);

        $responce = $this->actingAs($user, 'api')->put("/api/news/" . $news->id, [
            'title' => 'Text title',
            'preview' => 'Preview',
            'body' => 'Body body body',
            'date' => '2020-04-01',
            'author_id' => $author->id,
            'image' => 'http://localhost/example.jpg'
        ]);

        $responce->assertStatus(200);

        $responce->assertJsonFragment([
            'id' => $news->id,
            'title' => 'Text title',
            'preview' => 'Preview',
            'body' => 'Body body body',
            'date' => '2020-04-01',
            'image' => 'http://localhost/example.jpg',
            'author' => [
                'id' => $author->id,
                'name' => $author->name,
            ]
        ]);
    }


    /**
     * Delete news
     */
    public function testDelete()
    {
        $user = factory(User::class)->create();
        $author = factory(Author::class)->create();
        $news = factory(News::class)->create([
            'author_id' => $author->id,
        ]);

        $responce = $this->actingAs($user, 'api')->delete("/api/news/" . $news->id);

        $responce->assertStatus(200);

        $responce->assertJsonFragment(['deleted' => true]);
    }
}
