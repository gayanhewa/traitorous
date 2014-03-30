<?hh // strict
namespace traitorous\http\headers\response;

use traitorous\http\headers\HttpResponseHeader;

class TransferEncodingHeader extends HttpResponseHeader {

    public function getKey(): string {
        return "Transfer-Encoding";
    }

}