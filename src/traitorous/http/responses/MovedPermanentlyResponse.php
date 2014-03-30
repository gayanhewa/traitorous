<?hh // strict
namespace traitorous\http\responses;

use traitorous\http\HttpResponse;

class MovedPermanentlyResponse extends HttpResponse {

    public function statusCode(): int {
        return 301;
    }

}