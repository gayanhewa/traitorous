<?hh // strict
namespace traitorous\http\headers\response;

use \string;
use traitorous\http\headers\HttpResponseHeader;

class ContentEncodingHeader extends HttpResponseHeader {

    public function getKey(): string {
        return "Content-Encoding";
    }

}