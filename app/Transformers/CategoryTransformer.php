<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Category;

class CategoryTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Category $c)
    {
        return [
            'id'        =>  $c->id,
            'title'     =>  $c->title,
            'created_at'=>  $c->created_at->timestamp,
        ];
    }
}
