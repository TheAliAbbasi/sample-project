<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\User;

class UserTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $u)
    {
        return [
          'fname'      =>  $u->fname,
          'lname'      =>  $u->lname,
          'username'   =>  $u->username,
          'email'      =>  $u->email,
          'is_newsletter' =>  $u->is_newsletter,
          'profile_picture' =>  $u->profile_picture,
        ];
    }
}
