<?hh // strict
namespace traitorous\http\responses;

use traitorous\http\HttpResponse;

class PartialContentResponse extends HttpResponse {

    public function statusCode(): int {
        return 206;
    }

}