<?hh // strict
namespace traitorous\http\responses;

use traitorous\http\HttpResponse;

class FailedDependencyResponse extends HttpResponse {

    public function statusCode(): int {
        return 424;
    }

}