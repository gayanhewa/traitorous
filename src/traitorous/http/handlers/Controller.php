<?hh // decl
namespace traitorous\http\handlers;

use traitorous\Combinatorial;
use traitorous\Revolver;
use traitorous\http\HttpRequestHandler;
use traitorous\http\HttpRequest;
use traitorous\http\HttpResponse;
use traitorous\algebraic\SemiGroup;
use traitorous\outlaw\Add;

abstract class Controller implements HttpRequestHandler, SemiGroup {

    public function middleware(): Vector<HttpRouteMiddleware> {
        return new Vector();
    }

    public function apply(HttpRequest $request): HttpResponse {
        return $this->_foldMiddlewareIntoController()->handle($request);
    }

    public function add(Add $other): HttpRequestHandler {
        throw new \DomainException("The controller must be the target of middleware, not middleware itself");
    }

    private function _foldMiddlewareIntoController(): HttpRequestHandler {
        return array_reduce(
            array_reverse($this->middleware()->toArray()),
            Combinatorial::flip1(Revolver::add()),
            $this
        );
    }

}
