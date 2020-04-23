<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'preview', 'body', 'image', 'published_at', 'author_id',
    ];


    /**
     *  Load author
     */
    public function author()
    {
        return $this->hasOne(Author::class, "id", "author_id");
    }
}
