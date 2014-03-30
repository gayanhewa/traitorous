<?hh // strict
namespace traitorous\http\responses;

use traitorous\http\HttpResponse;

class ConflictResponse extends HttpResponse {

    public function statusCode(): int {
        return 409;
    }

}