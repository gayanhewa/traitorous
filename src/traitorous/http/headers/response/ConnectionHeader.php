<?hh // strict
namespace traitorous\http\headers\response;

use traitorous\http\headers\HttpResponseHeader;

class ConnectionHeader extends HttpResponseHeader {

    public function getKey(): string {
        return "Connection";
    }

}