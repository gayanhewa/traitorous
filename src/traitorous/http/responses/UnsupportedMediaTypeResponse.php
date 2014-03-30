<?hh // strict
namespace traitorous\http\responses;

use traitorous\http\HttpResponse;

class UnsupportedMediaTypeResponse extends HttpResponse {

    public function statusCode(): int {
        return 415;
    }

}