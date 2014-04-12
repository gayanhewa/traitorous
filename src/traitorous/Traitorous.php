<?hh // strict
namespace traitorous;

use traitorous\http\HttpRequest;
use traitorous\http\HttpRouter;
use traitorous\http\HttpRequestHandler;
use traitorous\http\HttpResponseConsumer;
use traitorous\http\handlers\Controller;
use traitorous\http\handlers\HttpRouteMiddleware;
use traitorous\http\handlers\InjectableHandler;

final class Traitorous {

    public function __construct(
        private Traversable<HttpRouteMiddleware> $_middleware,
        private HttpRouter $_router,
        private (function(): HttpRequestHandler) $_default
    ) { }

    public function run(): void {
        $request    = new HttpRequest();
        $consumer   = new HttpResponseConsumer();
        $middleware = new Vector($this->_middleware);
        $router     = $this->_router();
        $handler    = Controller::foldMiddleware($router, $middleware);
        $response   = $handler->apply($request);
        
        echo $consumer->consume($response);
    }

    private function _router(): HttpRequestHandler {
        return new InjectableHandler(
            ($req) ==> $this->_router
                            ->route($req)
                            ->getOrElse($this->_default)
                            ->apply($req)
        );
    }

}