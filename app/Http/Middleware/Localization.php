<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

//        App::setLocale($request->header('Language', config('app.locale')));


        $response = $next($request);


        // if ($response instanceof \Illuminate\Http\JsonResponse) {
        //     $Data = $response->getData(true);


        //     if (isset($Data['data'])) {
        //         $response->setData($Data['data']);
        //     }
        // }

        return $response;
    }
}
