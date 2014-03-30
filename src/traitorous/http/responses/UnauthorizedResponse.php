<?hh // strict
namespace traitorous\http\responses;

use traitorous\http\HttpResponse;

class UnauthorizedResponse extends HttpResponse {

    public function statusCode(): int {
        return 401;
    }

}