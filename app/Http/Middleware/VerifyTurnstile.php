<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Http;

class VerifyTurnstile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // if (!$request->has('cf-turnstile-response')) {
        //     return response()->json(['error' => 'Turnstile token not provided'], 422);
        // }

        // $response = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
        //     'secret' => config('services.turnstile.secret_key'),
        //     'response' => $request->input('cf-turnstile-response'),
        //     'remoteip' => $request->ip(),
        // ]);

        // if (!$response->successful() || !$response->json('success')) {
        //     return response()->json(['error' => 'Invalid Turnstile token'], 422);
        // }

        // return $next($request);
    }
}