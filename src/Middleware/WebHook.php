<?php

namespace Trigold\Udesk\Middleware;

use Closure;
use Illuminate\Http\Request;
use Trigold\Udesk\Facades\Crm;

class WebHook
{
    /**
     * @param  Request  $request
     * @param  Closure  $next
     *
     * @return mixed
     */
    public function handle(Request $request,Closure $next){
        Crm::webHookAuth($request->post());
        return $next($request);
    }
}