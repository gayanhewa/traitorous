<?hh // strict
namespace traitorous\http\headers\response;

use \string;
use traitorous\http\headers\HttpResponseHeader;

class ConnectionHeader extends HttpResponseHeader {

    public function getKey(): string {
        return "Connection";
    }

}