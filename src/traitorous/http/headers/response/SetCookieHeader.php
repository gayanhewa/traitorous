<?hh // strict
namespace traitorous\http\headers\response;

use \string;
use traitorous\http\headers\HttpResponseHeader;

class SetCookieHeader extends HttpResponseHeader {

    public function getKey(): string {
        return "Set-Cookie";
    }

}