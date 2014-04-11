<?hh // strict
namespace traitorous\http\handlers;

use traitorous\http\HttpRequestHandler;
use traitorous\http\HttpRequest;
use traitorous\http\HttpResponse;
use traitorous\http\routes\HttpRouteRule;
use traitorous\algebraic\SemiGroup;
use traitorous\outlaw\Add;

abstract class HttpRouteMiddleware implements HttpRequestHandler,
                                              SemiGroup<HttpRequestHandler>
{

    abstract public function intercept(HttpRequest $request,
                                       HttpRequestHandler $next): HttpResponse;

    public function route(): HttpRouteRule {
        throw new \Exception("You can't define a route on an unconnected middleware");
    }

    public function handle(HttpRequest $request): HttpResponse {
        throw new \Exception("Can't call a middleware unless it's been wired to a controller");
    }

    public function apply(HttpRequest $request): HttpResponse {
        throw new \Exception("Can't call a middleware unless it's been wired to a controller");
    }

    public function add(HttpRequestHandler $other): HttpRequestHandler {
        return new HttpConnectedMiddleware($this, $other);
    }

}