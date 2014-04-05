<?hh // strict
namespace traitorous\http\headers\response;

use traitorous\http\headers\HttpResponseHeader;

class ContentEncodingHeader extends HttpResponseHeader {

    public function getKey(): string {
        return "Content-Encoding";
    }

}