<?hh // strict
namespace traitorous\http\responses;

use traitorous\http\HttpResponse;

class OkResponse extends HttpResponse {

    public function statusCode(): int {
        return 200;
    }

}