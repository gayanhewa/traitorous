<?hh // strict
namespace traitorous;

use \traitorous\http\HttpRequest;
use \traitorous\http\HttpRouter;
use \traitorous\http\HttpRequestHandler;
use \traitorous\http\HttpResponseConsumer;

final class Traitorous {

    public function __construct(
        private HttpRouter $_router,
        private HttpRequestHandler $_default
    ) { }

    public function run(): void {
        $request  = new HttpRequest();
        $consumer = new HttpResponseConsumer();
        $route    = $this->_router
                         ->route($request)
                         ->getOrDefault($this->_default);
        $response = $route->apply($request);
        
        echo $consumer->consume($response);
    }

}