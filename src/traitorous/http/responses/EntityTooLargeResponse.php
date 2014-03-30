<?hh // strict
namespace traitorous\http\responses;

use traitorous\http\HttpResponse;

class EntityTooLargeResponse extends HttpResponse {

    public function statusCode(): int {
        return 413;
    }

}