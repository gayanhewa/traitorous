<?hh // strict
namespace traitorous\http\responses;

use traitorous\http\HttpResponse;

class UnprocessableEntityResponse extends HttpResponse {

    public function statusCode(): int {
        return 422;
    }

}