<?hh // strict
namespace traitorous\http\headers\response;

use traitorous\http\headers\HttpResponseHeader;

class ServerHeader extends HttpResponseHeader {

    public function getKey(): string {
        return "Server";
    }

}