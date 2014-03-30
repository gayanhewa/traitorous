<?hh // strict
namespace traitorous\http\responses;

use traitorous\http\HttpResponse;

class GatewayTimeoutResponse extends HttpResponse {

    public function statusCode(): int {
        return 504;
    }

}