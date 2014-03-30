<?hh // strict
namespace traitorous\http\responses;

use traitorous\http\HttpResponse;

class MissingResponse extends HttpResponse {

    public function statusCode(): int {
        return 404;
    }

}