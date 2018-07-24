<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Spatie\Fractal\Fractal;
use App\Http\Controllers\Controller;
use App\Transformers\PostTransformer;
use App\Http\Requests\PostRequest as Request;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $psots = Post::paginate();
        $psots_array = Fractal::create()
            ->collection($psots->getCollection(), new PostTransformer)
            ->paginateWith(new IlluminatePaginatorAdapter($psots))
            ->toArray();
        return response()->json($psots_array);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->only(['title', 'content', 'category_id']);
        $post = Post::create($input);

        return fractal($post, new PostTransformer)->respond();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return fractal($post, new PostTransformer)->respond();        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $input = $request->only(['title', 'content', 'category_id']);
        $post->update($input);
        return fractal($post, new PostTransformer)->respond();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response(null, 204);
    }

    public function togglePublish(Post $post) {
        $post->is_published = !$post->is_published;
        $post->save();

        return response(null, 204);
    }
}
