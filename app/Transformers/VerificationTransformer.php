<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\VerifyCode;

class VerificationTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(VerifyCode $verification)
    {
        return [
            'mobile'          =>  $verification->mobile,
            'code'            =>  $verification->code,
            'created_at'      =>  $verification->created_at->timestamp,
            'updated_at'      =>  $verification->updated_at->timestamp,
        ];
    }
}
