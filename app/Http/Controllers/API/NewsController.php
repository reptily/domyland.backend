<?php

namespace App\Http\Controllers\API;

use App\Author;
use App\Http\Controllers\Controller;
use App\Http\Requests\NewsCreate;
use App\Http\Requests\NewsRequest;
use App\Http\Resources\NewsCollection;
use App\Http\Resources\NewsResource;
use App\News;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return NewsCollection
     */
    public function index(Request $request)
    {
        return new NewsCollection(News::orderBy('published_at','desc')->paginate((int)$request->per_page ?? 15));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return NewsCollection
     */
    public function indexAuthors(Request $request){
        return new NewsCollection(News::where('author_id', $request->id ?? 0)->orderBy('published_at','desc')->paginate((int)$request->per_page ?? 15));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param NewsRequest $request
     * @return NewsResource
     */
    public function store(NewsRequest $request)
    {
        $author = Author::find($request->author_id);

        if (empty($author)) {
            return response()->json(['error' => 'not_fount_author'], 400);
        }

        $news = News::create([
            'title' => $request->title,
            'preview' => $request->preview,
            'body' => $request->body,
            'published_at' => Carbon::parse($request->date)->format("Y-m-d"),
            'image' => $request->image,
            'author_id' => $request->author_id,
        ]);

        return new NewsResource($news);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return NewsResource
     */
    public function show($id)
    {
        $news = News::find($id);
        if (empty($news)) {
            return response()->json(['error' => 'news_not_found'], 404);
        } else {
            return new NewsResource($news);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param NewsRequest $request
     * @param int $id
     * @return NewsResource
     */
    public function update(NewsRequest $request, $id)
    {
        $news = News::find($id);
        if (empty($news)) {
            return response()->json(['error' => 'news_not_found'], 404);
        }

        $news->title = $request->title;
        $news->preview = $request->preview;
        $news->body = $request->body;
        $news->published_at = Carbon::parse($request->date)->format("Y-m-d");
        $news->image = $request->image;
        $news->author_id = $request->author_id;
        $news->save();

        return new NewsResource($news);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $news = News::find($id);
        if (empty($news)) {
            return response()->json(['error' => 'news_not_found'], 404);
        }

        $news->delete();
        return response()->json(['deleted' => true]);
    }
}
