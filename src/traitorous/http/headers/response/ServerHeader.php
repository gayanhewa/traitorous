<?hh // strict
namespace traitorous\http\headers\response;

use \string;
use traitorous\http\headers\HttpResponseHeader;

class ServerHeader extends HttpResponseHeader {

    public function getKey(): string {
        return "Server";
    }

}