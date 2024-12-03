<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ResponseMetadata
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
        $response = $next($request);
        if ($request['type'] == 'xmltei') {
            print 'xmltei';
        }
        else if ($response instanceof JsonResponse) {

            // Workaround, since $request->all() is not giving me the input parameters.
            $fields = collect([
                "language" => $request->language,
                "sura" => $request->sura,
                "verse" => $request->verse,
                "word" => $request->word,
                "category" => $request->category,
            ])->whereNotNull()->toArray();

            $payloadWithMeta = [
                'data' => json_decode($response->getContent(), true),
                'metadata' => array_merge(
                    [
                        "url" => $request->fullUrl(),
                    ],
                    $fields,
                )
            ];

            $response->setData($payloadWithMeta);

            return $response;
        }

        return $response;
    }
}
