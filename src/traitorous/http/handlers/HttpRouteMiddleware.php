<?hh // decl
namespace traitorous\http\handlers;

use \DomainException;
use traitorous\http\HttpRequestHandler;
use traitorous\http\HttpRequest;
use traitorous\http\HttpResponse;
use traitorous\algebraic\SemiGroup;
use traitorous\outlaw\Add;

abstract class HttpRouteMiddleware implements HttpRequestHandler, SemiGroup {

    abstract public function intercept(HttpRequest $request,
                                       HttpRequestHandler $next): HttpResponse;

    public function route(): HttpRouteRule {
        throw new DomainException("You can't define a route on an unconnected middleware");
    }

    public function handle(HttpRequest $request): HttpResponse {
        throw new DomainException("Can't call a middleware unless it's been wired to a controller");
    }

    public function apply(HttpRequest $request): HttpResponse {
        throw new DomainException("Can't call a middleware unless it's been wired to a controller");
    }

    public function add(Add $other): HttpRequestHandler {
        return new HttpConnectedMiddleware($this, $other);
    }

}