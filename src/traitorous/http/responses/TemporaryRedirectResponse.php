<?hh // strict
namespace traitorous\http\responses;

use traitorous\http\HttpResponse;

class TemporaryRedirectResponse extends HttpResponse {

    public function statusCode(): int {
        return 307;
    }

}