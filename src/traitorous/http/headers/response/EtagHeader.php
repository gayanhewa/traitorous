<?hh // strict
namespace traitorous\http\headers\response;

use traitorous\http\headers\HttpResponseHeader;

class EtagHeader extends HttpResponseHeader {

    public function getKey(): string {
        return "ETag";
    }

}