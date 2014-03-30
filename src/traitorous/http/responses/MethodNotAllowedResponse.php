<?hh // strict
namespace traitorous\http\responses;

use traitorous\http\HttpResponse;

class MethodNotAllowedResponse extends HttpResponse {

    public function statusCode(): int {
        return 405;
    }

}