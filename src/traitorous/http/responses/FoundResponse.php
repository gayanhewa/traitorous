<?hh // strict
namespace traitorous\http\responses;

use traitorous\http\HttpResponse;

class FoundResponse extends HttpResponse {

    public function statusCode(): int {
        return 302;
    }

}