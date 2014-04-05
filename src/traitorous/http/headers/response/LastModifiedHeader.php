<?hh // strict
namespace traitorous\http\headers\response;

use traitorous\http\headers\HttpResponseHeader;

class LastModifiedHeader extends HttpResponseHeader {

    public function getKey(): string {
        return "Last-Modified";
    }

}