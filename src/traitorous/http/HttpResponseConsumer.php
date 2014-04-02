<?hh // decl
namespace traitorous\http;

use traitorous\http\HttpResponse;
use traitorous\http\headers\HttpResponseHeader;
use traitorous\http\HttpResponseHeaders;


final class HttpResponseConsumer {

    private HttpResponseHeaders $_headers;

    public function __construct(): void {
        $this->_headers = new HttpResponseHeaders();
    }

    public function consume(HttpResponse $response): string {
        return $this->_setStatusCode($response)
                    ->_setHeaders($response)
                    ->_renderView($response);
    }

    private function _setStatusCode(HttpResponse $response): HttpResponseConsumer {
        http_response_code($response->statusCode());
        return $this;
    }

    private function _setHeaders(HttpResponse $response): HttpResponseConsumer {
        foreach ($response->headers()->toArray() as $header) {
            $this->_headers->set($header);
        }
        return $this;
    }

    private function _renderView(HttpResponse $response): string {
        return $response->view()->render();
    }

}