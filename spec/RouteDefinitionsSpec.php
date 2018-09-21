<?php namespace spec\Monolith\WebRouting;

use Monolith\WebRouting\Methods\GetMethod;
use Monolith\WebRouting\Middlewares;
use Monolith\WebRouting\Route;
use Monolith\WebRouting\RouteDefinitions;
use PhpSpec\ObjectBehavior;
use spec\Monolith\DependencyInjection\MiddlewareStub;
use spec\Monolith\DependencyInjection\OtherMiddlewareStub;

class RouteDefinitionsSpec extends ObjectBehavior {

    public function middlewareOne($r) {
        if ($r instanceof Route) {
            return new Route(
                $r->method(),
                $r->uri(),
                $r->controllerClass(),
                Middlewares::list(MiddlewareStub::class)->merge($r->middlewares())
            );
        }
        return $r;
    }

    function let() {

        //
//        Routes::list(
//            get('/', GetControllerStub::class),
//            get('/thank-you', GetControllerStub::class),
//
//            form('/register', Registration\RegistrationForm::class),
//
//            middleware([Middlewares\IsAdmin::class],
//
//                prefix('/admin',
//                    get('/dashboard', GetControllerStub::class),
//                    get('/profile-page', GetControllerStub::class),
//
//                    prefix('/users',
//                        get('/list', GetControllerStub::class),
//                        get('/delete/{id}', GetControllerStub::class)
//                    )
//                )
//            )
//        );

        $addPrefix = function ($r) {

            if ($r instanceof Route) {
                return new Route(
                    $r->method(),
                    '/prefix' . $r->uri(),
                    $r->controllerClass(),
                    $r->middlewares()
                );
            }
            return $r;
        };

        $middlewareTwo = function($r) {
            if ($r instanceof Route) {
                return new Route(
                    $r->method(),
                    $r->uri(),
                    $r->controllerClass(),
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


    function it_can_flatten_nested_route_groups() {

        $this->shouldHaveType(RouteDefinitions::class);

        $this->flatten()->count()->shouldBe(13);

        $this->flatten()->each(function ($route) {

            expect($route)->shouldHaveType(Route::class);
        });
    }

    function it_can_propagate_middlewares_through_nested_route_definitions() {

        $routes = $this->flatten()->toArray();

        $this->compareRange(range(1, 2), $routes, '', new Middlewares);
        $this->compareRange(range(3, 4), $routes, '', Middlewares::list(MiddlewareStub::class));
    }

    function it_can_apply_a_transformation_function_to_the_flattened_routes() {

        $routes = $this->flatten()->toArray();

        $this->compareRange(range(5, 8), $routes, '/prefix', Middlewares::list(MiddlewareStub::class));
        $this->compareRange(range(9, 12), $routes, '/prefix', Middlewares::list(MiddlewareStub::class, OtherMiddlewareStub::class));
        $this->compareRange(range(13, 13), $routes, '/prefix/prefix', Middlewares::list(MiddlewareStub::class, OtherMiddlewareStub::class));
    }

    private function compareRange(array $range, RouteDefinitions $routes, $prefix = '', Middlewares $middlewares): void {

        foreach ($range as $i) {
            $routes[$i - 1]->uri()->shouldBe("{$prefix}/{$i}");
            $routes[$i - 1]->middlewares()->equals($middlewares)->shouldBe(true);
        }
    }
}