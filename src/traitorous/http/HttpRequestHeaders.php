<?hh // decl
namespace traitorous\http;

use \string;
use traitorous\Option;
use traitorous\option\OptionFactory;

class HttpRequestHeaders {

    public function __construct(private Map<string, string> $_map) { }

    public function get(string $header): Option<string> {
        $normalized = $this->_normalizeKey($header);
        $optionFactory = new OptionFactory(); // TODO: fix this hack
        return $optionFactory->fromValue($this->_map->get($normalized));
    }

    private function _normalizeKey(string $key): string {
        return "HTTP_" . str_replace("-", "_", strtoupper($key));
    }

}