<?hh // strict
namespace traitorous\http\headers\response;

use \string;
use traitorous\http\headers\HttpResponseHeader;

class ProxyAuthenticationHeader extends HttpResponseHeader {

    public function getKey(): string {
        return "Proxy-Authentication";
    }

}