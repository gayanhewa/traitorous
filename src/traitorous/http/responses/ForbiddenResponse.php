<?hh // strict
namespace traitorous\http\responses;

use traitorous\http\HttpResponse;

class ForbiddenResponse extends HttpResponse {

    public function statusCode(): int {
        return 403;
    }

}