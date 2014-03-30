<?hh // strict
namespace traitorous\http\headers\response;

use \string;
use traitorous\http\headers\HttpResponseHeader;

class ContentLocationHeader extends HttpResponseHeader {

    public function getKey(): string {
        return "Content-Location";
    }

}