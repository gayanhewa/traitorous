<?hh // strict
namespace traitorous\http\headers\response;

use traitorous\http\headers\HttpResponseHeader;

class ContentTypeHeader extends HttpResponseHeader {

    public function getKey(): string {
        return "Content-Type";
    }

}