<?hh // strict
namespace traitorous\http\headers\response;

use \string;
use traitorous\http\headers\HttpResponseHeader;

class AllowHeader extends HttpResponseHeader {

    public function getKey(): string {
        return "Allow";
    }

}