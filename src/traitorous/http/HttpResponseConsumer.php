<?hh // decl
namespace traitorous\http;

use traitorous\http\HttpResponse;
use traitorous\http\headers\HttpResponseHeader;
use traitorous\http\headers\response\SetCookieHeader;
use traitorous\http\HttpResponseHeaders;
use traitorous\Option;
use traitorous\option\Some;
use traitorous\option\None;

final class HttpResponseConsumer {

    private HttpResponseHeaders $_headers;

    public function __construct(): void {
        $this->_headers = new HttpResponseHeaders();
    }

    public function consume(HttpResponse $response): string {
        return $this
            ->_setStatusCode($response)
            ->_setHeaders($response)
            ->_setSession($response)
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

    private function _setSession(HttpResponse $response): HttpResponseConsumer {
        $this->_generateSessionCookie($response)->map(($n) ==> $this->_headers->set(new SetCookieHeader($n)));
        if ($response->statusCode() !== 404) {
            $this->_headers->set(new SetCookieHeader($this->_generateFlashCookie($response)), false);
        }
        return $this;
    }
    private function _generateSessionCookie(HttpResponse $response): Option<string> {
        return $response->session()->cata(
            ()         ==> new None(),
            ($session) ==> new Some("session={$session->signature()}{$session->toJson()}; Path=/; HttpOnly")
        );
    }

    private function _generateFlashCookie(HttpResponse $response): string {
        return $response->flash()->cata(
            ()       ==> "flash=none; Path=/; HttpOnly",
            ($flash) ==> "flash={$flash->signature()}{$flash->toJson()}; Path=/; HttpOnly"
        );
    }

    private function _renderView(HttpResponse $response): string {
        return $response->view()->render();
    }

}