<?hh // strict
namespace traitorous\http\responses;

use traitorous\http\HttpResponse;

class ResetContentResponse extends HttpResponse {

    public function statusCode(): int {
        return 205;
    }

}