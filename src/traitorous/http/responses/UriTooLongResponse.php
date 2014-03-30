<?hh // strict
namespace traitorous\http\responses;

use traitorous\http\HttpResponse;

class UriTooLongResponse extends HttpResponse {

    public function statusCode(): int {
        return 415;
    }

}