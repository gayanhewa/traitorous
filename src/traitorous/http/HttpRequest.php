<?hh // decl
namespace traitorous\http;

use \Exception;
use traitorous\ImmutableMap;
use traitorous\Option;
use traitorous\option\OptionFactory;
use traitorous\option\Some;
use traitorous\option\None;

class HttpRequest {

    private static bool $_initialized = false;

    private ImmutableMap<string, string> $_server;

    private ImmutableMap<string, string> $_get;

    private ImmutableMap<string, sting> $_post;

    public function __construct() {
        if (self::$_initialized) {
            throw new Exception(
                "There can only ever be one HttpRequest initialized. ".
                "Please practice good Dependency Injection."
            );
        } else {
            $this->_server  = new ImmutableMap($_SERVER);
            $this->_get     = new ImmutableMap($_GET);
            $this->_post    = new ImmutableMap($_POST);
            $this->_headers = new HttpRequestHeaders($this->_server);
        }
    }

    public function getMethod(): Option<string> {
        return $this->_server->get("REQUEST_METHOD");
    }

    public function getPath(): Option<string> {
        return $this->_server->get("REQUEST_URI");
    }


    public function getHeader(string $header) {
        return $this->_headers->get($header);
    }

    public function getHeadersObject(): HttpRequestHeaders {
        return $this->_headers;
    }

    public function getServerProperty(string $property): Option<string> {
        return $this->_server->get($property);
    }

    public function getServerPropertyMap(): ImmutableMap<string, string> {
        return $this->_server;
    }

    public function getQueryParam(string $property): Option<string> {
        return $this->_get->get($property);
    }

    public function getQueryParamMap(): ImmutableMap<string, string> {
        return $this->_get;
    }

    public function getPostParam(string $property): Option<string> {
        return $this->_post->get($property);
    }

    public function getPostParamMap(): ImmutableMap<string, string> {
        return $this->_post;
    }

    public function session(string $secret): Session {
        return Session::fromRequest($secret, $this);
    }

}
