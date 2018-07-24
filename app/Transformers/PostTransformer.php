<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Post;

class PostTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Post $p)
    {
        return [
            'id'        =>  $p->id,
            'title'     =>  $p->title,
            'content'   =>  $p->content,
            'is_published'   =>  $p->is_published,
            'created_at'=>  $p->created_at->timestamp,
        ];
    }
}
