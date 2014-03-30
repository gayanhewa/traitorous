<?hh // strict
namespace traitorous\http\responses;

use traitorous\http\HttpResponse;

class GoneResponse extends HttpResponse {

    public function statusCode(): int {
        return 410;
    }

}