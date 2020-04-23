<?php

namespace App\Http\Resources;

use App\Author;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'preview' => $this->preview,
            'body' => $this->body,
            'image' => $this->image,
            'date' => $this->published_at,
            'author' => new AuthorResource(Author::find($this->author_id))
        ];
    }
}
