<?hh // strict
namespace traitorous\http\responses;

use traitorous\http\HttpResponse;

class CacheHitResponse extends HttpResponse {

    public function statusCode(): int {
        return 304;
    }

}