<?hh // decl
namespace traitorous\http;

use \Exception;
use traitorous\Option;
use traitorous\option\OptionFactory;
use traitorous\option\Some;
use traitorous\option\None;

class HttpRequest {

    private static bool $_initialized = false;

    private Map<string, mixed> $_server;

    private Map<string, mixed> $_get;

    private Map<string, mixed> $_post;

    public function __construct() {
        if (self::$_initialized) {
            throw new Exception(
                "There can only ever be one HttpRequest initialized. ".
                "Please practice good Dependency Injection."
            );
        } else {
            $this->_server  = Map::fromArray($_SERVER);
            $this->_get     = Map::fromArray($_GET);
            $this->_post    = Map::fromArray($_POST);
            $this->_headers = new HttpRequestHeaders($this->_server);
        }
    }

    public function getMethod(): Option<string> {
        return OptionFactory::fromValue($this->_server->get("REQUEST_METHOD"));
    }

    public function getPath(): Option<string> {
        return OptionFactory::fromValue($this->_server->get("REQUEST_URI"));
    }


    public function getHeader(string $header) {
        return $this->_headers->get($header);
    }

    public function getHeadersObject(): HttpRequestHeaders {
        return $this->_headers;
    }

    public function getServerProperty(string $property): Option<string> {
        return OptionFactory::fromValue($this->_server->get($property));
    }

    public function getServerPropertyMap(): Map<string, string> {
        return $this->_server;
    }

    public function getQueryParam(string $property): Option<string> {
        return OptionFactory::fromValue($this->_get->get($property));
    }

    public function getQueryParamMap(): Map<string, string> {
        return $this->_get;
    }

    public function getPostParam(string $property): Option<string> {
        return OptionFactory::fromValue($this->_post->get($property));
    }

    public function getPostParamMap(): Map<string, string> {
        return $this->_post;
    }

}
