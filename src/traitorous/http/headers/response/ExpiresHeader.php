<?hh // strict
namespace traitorous\http\headers\response;

use traitorous\http\headers\HttpResponseHeader;

class ExpiresHeader extends HttpResponseHeader {

    public function getKey(): string {
        return "Expires";
    }

}