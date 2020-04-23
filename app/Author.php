<?php

namespace App;

use App\News;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];


    public function news()
    {
        return $this->hasMany(News::class, "author_id", "id");
    }
}
