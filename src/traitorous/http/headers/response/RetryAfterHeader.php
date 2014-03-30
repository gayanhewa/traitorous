<?hh // strict
namespace traitorous\http\headers\response;

use \string;
use traitorous\http\headers\HttpResponseHeader;

class RetryAfterHeader extends HttpResponseHeader {

    public function getKey(): string {
        return "Retry-After";
    }

}