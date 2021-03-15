<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Facades\MicrosoftGraphFacade as Graph;

class oAuthTokenVerification
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // TODO: Remove Masterkey
        if ($request->get('oAuth2accessToken')=="MasterKeyMarquardt2021!") {
            return $next($request);
        }
        if (!$request->has('oAuth2accessToken')) {
            abort(403, 'Missing Micosoft oAuth access token');
        }
        if (!Graph::verifyToken($request->get('oAuth2accessToken'))) {

            abort(403, 'Invalid Micosoft oAuth access token');
        }
        return $next($request);
    }
}
