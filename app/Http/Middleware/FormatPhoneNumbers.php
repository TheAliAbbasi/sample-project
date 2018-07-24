<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TransformsRequest as Middleware;

class FormatPhoneNumbers extends Middleware
{
    public function transform($k, $v) {
      if(in_array($k, ['phone', 'phone_number', 'mobile']))
          return '0'.substr($v, -10);
      return $v;
    }
}
