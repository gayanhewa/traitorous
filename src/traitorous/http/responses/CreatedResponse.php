<?hh // strict
namespace traitorous\http\responses;

use traitorous\http\HttpResponse;

class CreatedResponse extends HttpResponse {

    public function statusCode(): int {
        return 201;
    }

}