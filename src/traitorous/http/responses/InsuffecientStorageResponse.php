<?hh // strict
namespace traitorous\http\responses;

use traitorous\http\HttpResponse;

class InsuffecientStorageResponse extends HttpResponse {

    public function statusCode(): int {
        return 507;
    }

}