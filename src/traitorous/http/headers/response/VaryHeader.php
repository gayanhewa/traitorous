<?hh // strict
namespace traitorous\http\headers\response;

use traitorous\http\headers\HttpResponseHeader;

class VaryHeader extends HttpResponseHeader {

    public function getKey(): string {
        return "Vary";
    }

}