<?hh // strict
namespace traitorous\http\headers\response;

use \string;
use traitorous\http\headers\HttpResponseHeader;

class PragmaHeader extends HttpResponseHeader {

    public function getKey(): string {
        return "Pragma";
    }

}