<?hh // strict
namespace traitorous\http;

use traitorous\http\HttpRequest;
use traitorous\Option;
use traitorous\option\None;
use traitorous\option\Some;

class HttpRouter {

    public function __construct(
        private Vector<HttpRequestHandler> $_routes
    ): void { }

    public function route(HttpRequest $request): Option<HttpRequestHandler> {
        return array_reduce(
            $this->_routes->toArray(),
            ($match, $handler) ==> {
                return $match->orElse(function() use($handler, $request) {
                    if ($handler->route()->validate($request)) {
                        return new Some($handler);
                    } else {
                        return new None();
                    }
                });
            },
            new None()
        );
    }

}
