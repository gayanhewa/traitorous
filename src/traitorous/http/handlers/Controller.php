<?hh // strict
namespace traitorous\http\handlers;

use traitorous\Combinatorial;
use traitorous\Revolver;
use traitorous\http\HttpRequestHandler;
use traitorous\http\HttpRequest;
use traitorous\http\HttpResponse;
use traitorous\http\routes\HttpRouteRule;
use traitorous\algebraic\SemiGroup;
use traitorous\outlaw\Add;

abstract class Controller implements HttpRequestHandler,
                                     SemiGroup<HttpRequestHandler>
{

    public function middleware(): Vector<HttpRouteMiddleware> {
        return new Vector([]);
    }

    public function apply(HttpRequest $request): HttpResponse {
        $handler = Controller::foldMiddleware($this, $this->middleware());
        return $handler->handle($request);
    }

    public function add(HttpRequestHandler $other): HttpRequestHandler {
        throw new \Exception(
            "The controller must be the target of middleware, not middleware itself"
        );
    }

    public static function foldMiddleware(
        HttpRequestHandler $init,
        Vector<HttpRouteMiddleware> $middleware
    ): HttpRequestHandler {
        return array_reduce(
            array_reverse($middleware->toArray()),
            Combinatorial::flip1(Revolver::add()),
            $init
        );
    }

}
