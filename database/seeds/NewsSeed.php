<?php

use App\News;
use App\Author;
use Illuminate\Database\Seeder;

class NewsSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Author::class, 10)->create()->each(function ($author) {
            factory(News::class, 100)->create(['author_id' => $author->id]);
        });
    }
}
