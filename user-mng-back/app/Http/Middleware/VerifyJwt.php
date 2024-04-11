<?php

namespace App\Http\Middleware;

use Closure;
use aliirfaan\LaravelSimpleJwt\Services\JwtHelperService;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyJwt
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $jwtService = new JwtHelperService();
        $jwt = $request -> header('jwt');
        $result = $jwtService->verifyJwtToken($jwt);
        if($result['errors']) {
            return response([
                'message' => $result['message'],
            ], 403);
        }
        else {
            $user = User::firstWhere('jwt', $jwt);
            if($user) {
                $payload = $result['result'];
                $request -> headers -> set('id', $user -> id);
                return $next($request);
            }
            else {
                return response([
                    'message' => 'Bad token',
                ], 403);
            }
        }
    }
}
