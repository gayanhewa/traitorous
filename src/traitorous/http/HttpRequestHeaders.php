<?hh // decl
namespace traitorous\http;

use traitorous\ImmutableMap;
use traitorous\Option;
use traitorous\option\OptionFactory;

class HttpRequestHeaders {

    public function __construct(private ImmutableMap<string, string> $_map) { }

    public function get(string $header): Option<string> {
        $normalized = $this->_normalizeKey($header);
        return $this->_map->get($normalized);
    }

    private function _normalizeKey(string $key): string {
        return "HTTP_" . str_replace("-", "_", strtoupper($key));
    }

}