<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

// Load models
use App\Models\Store;

class CheckStoreId
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // find store is exist or not
        $storeId     = auth()->user()->store_id;
        $storesModel = Store::find($storeId);
        if(empty($storesModel))
        {
            return redirect()->route('login');
        }
        return $next($request);
    }
}
