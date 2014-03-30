<?hh // strict
namespace traitorous\http\responses;

use traitorous\http\HttpResponse;

class InternalServerErrorResponse extends HttpResponse {

    public function statusCode(): int {
        return 500;
    }

}