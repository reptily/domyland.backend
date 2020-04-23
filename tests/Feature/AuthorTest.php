<?php

namespace Tests\Feature;

use App\Author;
use App\User;
use App\News;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    use RefreshDatabase;

    /**
     * List authors
     *
     * @return void
     */
    public function testIndex()
    {
        $user = factory(User::class)->create();
        $author = factory(Author::class)->create();
        $responce = $this->actingAs($user, 'api')->get('/api/author');

        $responce->assertStatus(200);
    }

    /**
     * Get news authors
     *
     * @return void
     */
    public function testShow()
    {
        $user = factory(User::class)->create();
        $author = factory(Author::class)->create();
        $news = factory(News::class)->create([
            'author_id' => $author->id,
        ]);

        $responce = $this->actingAs($user, 'api')->get('/api/author/' . $author->id);

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
}
