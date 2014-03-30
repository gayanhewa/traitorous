<?hh // strict
namespace traitorous\http\responses;

use traitorous\http\HttpResponse;

class ExpectationFailedResponse extends HttpResponse {

    public function statusCode(): int {
        return 417;
    }

}