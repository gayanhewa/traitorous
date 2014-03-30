<?hh // strict
namespace traitorous\http\responses;

use traitorous\http\HttpResponse;

class BadGatewayResponse extends HttpResponse {

    public function statusCode(): int {
        return 502;
    }

}