<?hh // strict
namespace traitorous\http\headers\response;

use \string;
use traitorous\http\headers\HttpResponseHeader;

class ContentMd5Header extends HttpResponseHeader {

    public function getKey(): string {
        return "Content-MD5";
    }

}