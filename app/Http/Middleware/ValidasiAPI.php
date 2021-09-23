<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helper\ResponseFormatter;
use App\Models\User;

class ValidasiAPI
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     * 5|0G95ZjjHnycOfmH5bFJgsQSKVhlbQBDtG3crTX5U
     */
    public function handle(Request $request, Closure $next)
    {
        if(!$request->token){
            return ResponseFormatter::error([
                "message"=>"Token tidak dikirim"
            ],"API Tidak Valid",500);
        }
        $cek = User::where('token_api',$request->token)->first();
        if(!isset($cek)){
            return ResponseFormatter::error([
                "message"=>"API Tidak Valid Login Ulang"
            ],"API Tidak Valid",500);
        }


       

        return $next($request);
    }
}
