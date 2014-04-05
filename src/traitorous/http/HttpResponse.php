<?hh // strict
namespace traitorous\http;

use traitorous\ImmutableVector;
use traitorous\ImmutableMap;
use traitorous\Option;
use traitorous\option\Some;
use traitorous\option\None;
use traitorous\render\View;
use traitorous\http\headers\HttpResponseHeader;
use traitorous\http\sessions\SignedSession;
use traitorous\http\sessions\FlashSession;

abstract class HttpResponse {

    abstract public function statusCode(): int;

    public function __construct(
        private View $_view,
        private ?ImmutableVector<HttpResponseHeader> $_headers = null,
        private ?SignedSession $_session = null,
        private ?FlashSession $_flash = null
    ) { }

    public function withHeader(HttpResponseHeader $header): HttpResponse {
        return $this->withHeaders(new ImmutableVector($header));
    }

    public function withHeaders(ImmutableVector<HttpResponseHeader> $headers): HttpResponse {
        return new static(
            $this->_view,
            $this->headers()->add($headers),
            $this->_session,
            $this->_flash
        );
    }

    public function withSession(SignedSession $session): HttpResponse {
        return new static(
            $this->_view,
            $this->_headers,
            $session,
            $this->_flash
        );
    }

    public function withFlash(FlashSession $flash): HttpResponse {
        return new static(
            $this->_view,
            $this->_headers,
            $this->_session,
            $flash
        );
    }

    public function headers(): ImmutableVector<HttpResponseHeader> {
        return ($this->_headers !== null) ? $this->_headers : new ImmutableVector();
    }

    public function session(): Option<Session> {
        return ($this->_session !== null) ? new Some($this->_session) : new None();
    }

   public function flash(): Option<Session> {
        return ($this->_flash !== null) ? new Some($this->_flash) : new None();
    }

    public function view(): View {
        return $this->_view;
    }

}