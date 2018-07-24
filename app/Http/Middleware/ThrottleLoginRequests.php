<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\VerifyCode;

class ThrottleLoginRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      if(!config('config.debug') AND $v = VerifyCode::whereMobile($request->mobile)->withinLastMinute()->first())
          abort(429, 'You have to wait '.(60 - $v->created_at->diffInSeconds()).' seconds before you can request for login again');
        return $next($request);
    }
}
