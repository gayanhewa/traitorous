<?hh // strict
namespace traitorous\http\responses;

use traitorous\http\HttpResponse;

class NonAcceptableResponse extends HttpResponse {

    public function statusCode(): int {
        return 406;
    }

}