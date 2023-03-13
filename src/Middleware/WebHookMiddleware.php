<?php

namespace Trigold\Udesk\Middleware;

use Closure;
use Illuminate\Http\Request;
use Trigold\Udesk\Laravel\Facades\Crm;

class WebHookMiddleware
{
    /**
     * @param  Request  $request
     * @param  Closure  $next
     *
     * @return mixed
     */
    public function handle(Request $request,Closure $next){
        try {
            Crm::webHookAuth($request->post());
        }catch (\Exception $e){
            return response($e->getMessage(), 403);
        }
        return $next($request);
    }
}
