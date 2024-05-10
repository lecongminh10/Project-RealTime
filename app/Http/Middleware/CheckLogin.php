<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckLogin 
{
    public function handle(Request $request, Closure $next)
    {
      
        if (!Auth::check()) {
          
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để truy cập trang này.');
        }
        return $next($request);
    }
}