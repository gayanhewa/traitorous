<?hh // strict
namespace traitorous\http\handlers;

use traitorous\http\HttpRequestHandler;
use traitorous\http\HttpRequest;
use traitorous\http\HttpResponse;
use traitorous\http\routes\HttpRouteRule;
use traitorous\algebraic\SemiGroup;
use traitorous\outlaw\Add;

final class InjectableHandler implements HttpRequestHandler,
                                  SemiGroup<HttpRequestHandler>
{

    public function __construct(
        private (function(HttpRequest): HttpResponse) $_handler
    ) { }

    public function handle(HttpRequest $request): HttpResponse {
        $handler = $this->_handler;
        return $handler($request);
    }

    public function apply(HttpRequest $request): HttpResponse {
        $handler = $this->_handler;
        return $handler($request);
    }

    public function route(): HttpRouteRule {
        throw new \Exception("You can't define a route on an InjectableHandler");
    }

    public function add(HttpRequestHandler $other): HttpRequestHandler {
        throw new \Exception(
            "This handler must be the target of middleware, not middleware itself"
        );
    }

}