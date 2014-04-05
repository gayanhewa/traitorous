<?hh // strict
namespace traitorous\http\headers\response;

use traitorous\http\headers\HttpResponseHeader;

class AgeHeader extends HttpResponseHeader {

    public function getKey(): string {
        return "Age";
    }

}