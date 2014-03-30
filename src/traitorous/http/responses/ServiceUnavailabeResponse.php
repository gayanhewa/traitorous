<?hh // strict
namespace traitorous\http\responses;

use traitorous\http\HttpResponse;

class ServiceUnavailableResponse extends HttpResponse {

    public function statusCode(): int {
        return 503;
    }

}