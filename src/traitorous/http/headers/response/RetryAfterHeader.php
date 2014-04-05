<?hh // strict
namespace traitorous\http\headers\response;

use traitorous\http\headers\HttpResponseHeader;

class RetryAfterHeader extends HttpResponseHeader {

    public function getKey(): string {
        return "Retry-After";
    }

}