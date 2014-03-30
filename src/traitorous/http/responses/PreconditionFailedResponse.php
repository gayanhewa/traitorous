<?hh // strict
namespace traitorous\http\responses;

use traitorous\http\HttpResponse;

class PreconditionFailedResponse extends HttpResponse {

    public function statusCode(): int {
        return 412;
    }

}