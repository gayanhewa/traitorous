<?hh // strict
namespace traitorous\http\responses;

use traitorous\http\HttpResponse;

class TooManyRequestResponse extends HttpResponse {

    public function statusCode(): int {
        return 429;
    }

}