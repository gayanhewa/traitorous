<?hh // decl
namespace traitorous\http;

use traitorous\render\View;
use traitorous\http\headers\HttpResponseHeader;

abstract class HttpResponse {

    private Vector<HttpResponseHeader> $_headers;

    private View $_view;

    abstract public function statusCode(): int;

    public function __construct(View $view): void {
        $this->_view    = $view;
        $this->_headers = new Vector();
    }

    public function withHeader(HttpResponseHeader $header): this {
        $this->_headers->push($header);
        return $this;
    }

    public function withHeaders(array $headers): this {
        return array_reduce(
            $headers->toArray(),
            (HttpResponse $response, HttpResponseHeader $header) ==> {
                return $response->withHeader($header);
            },
            $this
        );
    }

    public function headers(): Vector<HttpResponseHeader> {
        return $this->_headers;
    }

    public function view(): View {
        return $this->_view;
    }

}