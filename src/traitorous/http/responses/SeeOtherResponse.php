<?hh // strict
namespace traitorous\http\responses;

use traitorous\http\HttpResponse;

class SeeOtherResponse extends HttpResponse {

    public function statusCode(): int {
        return 303;
    }

}