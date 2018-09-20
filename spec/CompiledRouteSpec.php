<?php namespace spec\Monolith\WebRouting;

use Monolith\WebRouting\CompiledRoute;
use PhpSpec\ObjectBehavior;
use spec\Monolith\DependencyInjection\ControllerStub;

class CompiledRouteSpec extends ObjectBehavior {

    function let() {
        $httpMethod = 'get';
        $uri = 'uri';
        $controllerClass = ControllerStub::class;
        $controllerMethod = 'index';

        $this->beConstructedWith($httpMethod, $uri, $controllerClass, $controllerMethod);
    }

    function it_is_initializable() {
        $this->shouldHaveType(CompiledRoute::class);
        $this->httpMethod()->shouldBe('get');
        $this->controllerClass()->shouldBe(ControllerStub::class);
        $this->controllerMethod()->shouldBe('index');
    }

    function it_can_match_numeric_parameters() {
        $this->beConstructedWith('get', '/article/{numbers}', ControllerStub::class, 'index');

        $parameters = [];
        preg_match($this->regex()->getWrappedObject(), '/article/231', $parameters);

        expect($parameters['numbers'])->shouldBe('231');
    }

    function it_can_match_alphanumeric_parameters() {
        $this->beConstructedWith('get', '/article/{alpha}', ControllerStub::class, 'index');

        $parameters = [];
        preg_match($this->regex()->getWrappedObject(), '/article/a23b1', $parameters);

        expect($parameters['alpha'])->shouldBe('a23b1');
    }

    function it_can_match_hyphenated_parameters() {
        $this->beConstructedWith('get', '/article/{id}', ControllerStub::class, 'index');

        $parameters = [];
        preg_match($this->regex()->getWrappedObject(), '/article/123-abc-def', $parameters);

        
        expect($parameters['id'])->shouldBe('123-abc-def');
    }

    function it_can_match_despite_a_trailing_slash() {
        $this->beConstructedWith('get', '/article/{alpha}', ControllerStub::class, 'index');

        $parameters = [];
        preg_match($this->regex()->getWrappedObject(), '/article/a23b1/', $parameters);

        expect($parameters['alpha'])->shouldBe('a23b1');
    }
}