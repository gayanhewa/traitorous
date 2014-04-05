<?hh // strict
namespace traitorous\http\headers\response;

use traitorous\http\headers\HttpResponseHeader;

class ContentRangeHeader extends HttpResponseHeader {

    public function getKey(): string {
        return "Content-Range";
    }

}