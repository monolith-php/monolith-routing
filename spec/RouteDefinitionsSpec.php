<?php namespace spec\Monolith\WebRouting;

use Monolith\WebRouting\Methods\GetMethod;
use Monolith\WebRouting\Middlewares;
use Monolith\WebRouting\Route;
use Monolith\WebRouting\RouteDefinitions;
use Monolith\WebRouting\RouteParameters;
use PhpSpec\ObjectBehavior;

class RouteDefinitionsSpec extends ObjectBehavior
{
    public function middlewareOne($r)
    {
        if ($r instanceof Route) {
            return new Route(
                $r->method(),
                $r->uri(),
                $r->controllerClass(),
                new RouteParameters,
                Middlewares::list(MiddlewareStub::class)->merge($r->middlewares())
            );
        }
        return $r;
    }

    function let()
    {
        $addPrefix = function ($r) {
            if ($r instanceof Route) {
                return new Route(
                    $r->method(),
                    '/prefix' . $r->uri(),
                    $r->controllerClass(),
                    new RouteParameters,
                    $r->middlewares()
                );
            }
            return $r;
        };

        $middlewareTwo = function ($r) {
            if ($r instanceof Route) {
                return new Route(
                    $r->method(),
                    $r->uri(),
                    $r->controllerClass(),
                    new RouteParameters,
                    Middlewares::list(OtherMiddlewareStub::class)->merge($r->middlewares())
                );
            }
            return $r;
        };

        $this->beConstructedThrough('list', [
            GetMethod::defineRoute('/1', GetControllerStub::class),
            GetMethod::defineRoute('/2', GetControllerStub::class),
            RouteDefinitions::withTransformFunction([$this, 'middlewareOne'],
                GetMethod::defineRoute('/3', GetControllerStub::class),
                GetMethod::defineRoute('/4', GetControllerStub::class),
                RouteDefinitions::withTransformFunction($addPrefix,
                    GetMethod::defineRoute('/5', GetControllerStub::class),
                    GetMethod::defineRoute('/6', GetControllerStub::class),
                    GetMethod::defineRoute('/7', GetControllerStub::class),
                    GetMethod::defineRoute('/8', GetControllerStub::class),
                    RouteDefinitions::withTransformFunction($middlewareTwo,
                        GetMethod::defineRoute('/9', GetControllerStub::class),
                        GetMethod::defineRoute('/10', GetControllerStub::class),
                        RouteDefinitions::list(
                            GetMethod::defineRoute('/11', GetControllerStub::class),
                            GetMethod::defineRoute('/12', GetControllerStub::class)
                        ),
                        RouteDefinitions::withTransformFunction($addPrefix,
                            GetMethod::defineRoute('/13', GetControllerStub::class)
                        )
                    )
                )
            ),
        ]);
    }

    function it_can_flatten_nested_route_groups()
    {
        $this->shouldHaveType(RouteDefinitions::class);

        $this->flatten()->count()->shouldBe(13);

        $this->flatten()->each(function ($route) {
            expect($route)->shouldHaveType(Route::class);
        });
    }

    function it_can_propagate_middlewares_through_nested_route_definitions()
    {
        $routes = $this->flatten()->toArray();

        $this->assertRouteDetails($routes, 13, '/1', new Middlewares);
        $this->assertRouteDetails($routes, 12, '/2', new Middlewares);
        $this->assertRouteDetails($routes, 11, '/3', Middlewares::list(MiddlewareStub::class));
        $this->assertRouteDetails($routes, 10, '/4', Middlewares::list(MiddlewareStub::class));
    }

    function it_can_apply_a_transformation_function_to_the_flattened_routes()
    {
        $routes = $this->flatten()->toArray();

        $this->assertRouteDetails($routes, 9, '/prefix/5', Middlewares::list(MiddlewareStub::class));
        $this->assertRouteDetails($routes, 8, '/prefix/6', Middlewares::list(MiddlewareStub::class));
        $this->assertRouteDetails($routes, 7, '/prefix/7', Middlewares::list(MiddlewareStub::class));
        $this->assertRouteDetails($routes, 6, '/prefix/8', Middlewares::list(MiddlewareStub::class));

        $this->assertRouteDetails($routes, 5, '/prefix/9', Middlewares::list(MiddlewareStub::class, OtherMiddlewareStub::class));
        $this->assertRouteDetails($routes, 4, '/prefix/10', Middlewares::list(MiddlewareStub::class, OtherMiddlewareStub::class));
        $this->assertRouteDetails($routes, 3, '/prefix/11', Middlewares::list(MiddlewareStub::class, OtherMiddlewareStub::class));
        $this->assertRouteDetails($routes, 2, '/prefix/12', Middlewares::list(MiddlewareStub::class, OtherMiddlewareStub::class));

        $this->assertRouteDetails($routes, 1, '/prefix/prefix/13', Middlewares::list(MiddlewareStub::class, OtherMiddlewareStub::class));
    }

    private function assertRouteDetails(RouteDefinitions $routes, int $routeNumber, $uri, Middlewares $middlewares)
    {
        $routes[$routeNumber - 1]->uri()->shouldBe($uri);
        $routes[$routeNumber - 1]->middlewares()->equals($middlewares)->shouldBe(true);
    }

    private function compareRange(array $range, RouteDefinitions $routes, $prefix = '', Middlewares $middlewares): void
    {
        foreach ($range as $i) {
            $routes[$i - 1]->uri()->shouldBe("{$prefix}/{$i}");
            $routes[$i - 1]->middlewares()->equals($middlewares)->shouldBe(true);
        }
    }

    private function debug(RouteDefinitions $routes)
    {
        foreach ($routes as $route) {
            /** @var Route $route */
            echo $route->uri() . "\n";
        }

        die('');
    }
}