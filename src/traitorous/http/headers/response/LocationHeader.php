<?hh // strict
namespace traitorous\http\headers\response;

use \string;
use traitorous\http\headers\HttpResponseHeader;

class LocationHeader extends HttpResponseHeader {

    public function getKey(): string {
        return "Location";
    }

}