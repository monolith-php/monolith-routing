<?php namespace Monolith\WebRouting\Methods;

use Monolith\Collections\Collection;
use Monolith\Collections\Dictionary;
use Monolith\Http\Request;
use Monolith\Http\Response;
use Monolith\WebRouting\Middleware;

final class PathRoutingMiddleware implements Middleware
{
    public function process(
        Request $request,
        callable $next
    ): Response {
        $segmentNames = Collection::list(
            'one', 'two', 'three', 'four', 'five', 'six', 'seven'
        );

        $path = $segmentNames
            ->map(
                fn(string $name) => $request->appParameters()->get($name)
            )
            ->filter(
                fn($folder) => ! is_null($folder)
            )
            ->reduce(
                fn($path, $fileOrFolder) => $path . '/' . $fileOrFolder
            );

        if (stristr($path, '..')) {
            return Response::notFound();
        }

        if ( ! $path) {
            $path = '/index';
        }

        return $next(
            $request->addAppParameters(
                new Dictionary(
                    [
                        'path' => $path,
                    ]
                )
            )
        );
    }
}