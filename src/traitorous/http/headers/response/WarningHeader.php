<?hh // strict
namespace traitorous\http\headers\response;

use \string;
use traitorous\http\headers\HttpResponseHeader;

class WarningHeader extends HttpResponseHeader {

    public function getKey(): string {
        return "Warning";
    }

}