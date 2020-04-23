<?php

namespace App\Http\Resources;

use App\Author;
use Illuminate\Http\Resources\Json\ResourceCollection;

class NewsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Support\Collection
     */
    public function toArray($request)
    {
        $data = $this->collection;
        foreach ($data as $i => $val) {
            $data[$i]->author = new AuthorResource(Author::find($val->author_id));
            $data[$i]->date = $val->published_at;

            unset($data[$i]->published_at);
            unset($data[$i]->author_id);
        }
        return $data;
    }
}
