<?hh // strict
namespace traitorous\http\responses;

use traitorous\http\HttpResponse;

class HttpVersionNotSupportedResponse extends HttpResponse {

    public function statusCode(): int {
        return 505;
    }

}