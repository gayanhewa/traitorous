<?hh // strict
namespace traitorous\http;

use traitorous\ImmutableVector;
use traitorous\ImmutableMap;
use traitorous\Option;
use traitorous\option\Some;
use traitorous\option\None;
use traitorous\render\View;
use traitorous\http\headers\HttpResponseHeader;

abstract class HttpResponse {

    abstract public function statusCode(): int;

    public function __construct(
        private View $_view,
        private ?ImmutableVector<HttpResponseHeader> $_headers = null,
        private ?Session $_session = null
    ) { }

    public function withHeader(HttpResponseHeader $header): HttpResponse {
        return $this->withHeaders(new ImmutableVector($header));
    }

    public function withHeaders(ImmutableVector<HttpResponseHeader> $headers): HttpResponse {
        return new static(
            $this->_view,
            $this->headers()->add($headers),
            $this->_session
        );
    }

    public function withSession(Session $session): HttpResponse {
        return new static(
            $this->_view,
            $this->_headers,
            $session
        );
    }

    public function headers(): ImmutableVector<HttpResponseHeader> {
        if ($this->_headers !== null) {
            return $this->_headers;
        } else {
            return new ImmutableVector();
        }
    }

    public function session(): Option<Session> {
        if ($this->_session !== null) {
            return new Some($this->_session);
        } else {
            return new None();
        }
    }

    public function view(): View {
        return $this->_view;
    }

}