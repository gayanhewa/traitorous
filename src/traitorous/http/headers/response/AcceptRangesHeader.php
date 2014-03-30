<?hh // strict
namespace traitorous\http\headers\response;

use \string;
use traitorous\http\headers\HttpResponseHeader;

class AcceptRangesHeader extends HttpResponseHeader {

    public function getKey(): string {
        return "Accept-Ranges";
    }

}