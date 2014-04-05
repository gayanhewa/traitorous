<?hh // strict
namespace traitorous\http\headers\response;

use traitorous\http\headers\HttpResponseHeader;

class PragmaHeader extends HttpResponseHeader {

    public function getKey(): string {
        return "Pragma";
    }

}