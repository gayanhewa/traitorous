<?hh // strict
namespace traitorous\http\responses;

use traitorous\http\HttpResponse;

class MultiStatusResponse extends HttpResponse {

    public function statusCode(): int {
        return 207;
    }

}