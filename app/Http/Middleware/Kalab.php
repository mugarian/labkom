<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Dosen;
use Illuminate\Http\Request;

class Kalab
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $kalab = Dosen::where('user_id', auth()->user()->id)->first();
        if ($kalab->kepalalab == 'true' || auth()->user()->role == 'admin') {
            return $next($request);
        } else {
            abort(403);
        }
    }
}
