<?hh // strict
namespace traitorous\http\handlers;

use traitorous\http\HttpRequestHandler;
use traitorous\http\HttpRequest;
use traitorous\http\HttpResponse;
use traitorous\http\routes\HttpRouteRule;
use traitorous\algebraic\SemiGroup;
use traitorous\outlaw\Add;

final class HttpConnectedMiddleware implements HttpRequestHandler,
                                               SemiGroup<HttpRequestHandler>
{

    public function __construct(
        private HttpRouteMiddleware $_middleware,
        private HttpRequestHandler $_next
    ): void { }

    public function route(): HttpRouteRule {
        return $this->_next->route();
    }

    public function handle(HttpRequest $request): HttpResponse {
        return $this->_middleware->intercept($request, $this->_next);
    }

    public function apply(HttpRequest $request): HttpResponse {
        return $this->_middleware->intercept($request, $this->_next);
    }

    public function add(HttpRequestHandler $other): HttpRequestHandler {
        throw new \Exception("Can't wire in a middleware once it's already been connected once.");
    }

}