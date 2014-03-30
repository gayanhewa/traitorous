<?hh // strict
namespace traitorous\http\responses;

use traitorous\http\HttpResponse;

class RequestTimeoutResponse extends HttpResponse {

    public function statusCode(): int {
        return 408;
    }

}