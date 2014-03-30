<?hh // strict
namespace traitorous\http\responses;

use traitorous\http\HttpResponse;

class AcceptedResponse extends HttpResponse {

    public function statusCode(): int {
        return 202;
    }

}