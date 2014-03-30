<?hh // strict
namespace traitorous\http\headers\response;

use traitorous\http\headers\HttpResponseHeader;

class WwwAuthenticateHeader extends HttpResponseHeader {

    public function getKey(): string {
        return "WWW-Authenticate";
    }

}