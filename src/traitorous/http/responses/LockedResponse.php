<?hh // strict
namespace traitorous\http\responses;

use traitorous\http\HttpResponse;

class LockedResponse extends HttpResponse {

    public function statusCode(): int {
        return 423;
    }

}