<?hh // strict
namespace traitorous\http\responses;

use traitorous\http\HttpResponse;

class NoContentResponse extends HttpResponse {

    public function statusCode(): int {
        return 204;
    }

}