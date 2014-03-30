<?hh // strict
namespace traitorous\http\responses;

use traitorous\http\HttpResponse;

class NotImplementedResponse extends HttpResponse {

    public function statusCode(): int {
        return 501;
    }

}