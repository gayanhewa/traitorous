<?hh // strict
namespace traitorous\http\headers\response;

use traitorous\http\headers\HttpResponseHeader;

class LocationHeader extends HttpResponseHeader {

    public function getKey(): string {
        return "Location";
    }

}