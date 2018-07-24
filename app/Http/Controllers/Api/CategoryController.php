<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Spatie\Fractal\Fractal;
use App\Http\Controllers\Controller;
use App\Transformers\CategoryTransformer;
use App\Http\Requests\CategoryRequest as Request;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::paginate();
        $categories_array = Fractal::create()
            ->collection($categories->getCollection(), new CategoryTransformer)
            ->paginateWith(new IlluminatePaginatorAdapter($categories))
            ->toArray();
        return response()->json($categories_array);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->only('title');
        $category = Category::create($input);
        return fractal($category, new CategoryTransformer)->respond();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return fractal($category, new CategoryTransformer)->respond();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $input = $request->only('title');
        $category->update($input);
        return fractal($category, new CategoryTransformer)->respond();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response(null, 204);
    }
}
