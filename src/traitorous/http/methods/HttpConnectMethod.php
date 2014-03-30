<?hh // strict
namespace traitorous\http\methods;

use traitorous\http\HttpMethod;

final class HttpConnectMethod implements HttpMethod {

    public function __toString(): string {
        return "CONNECT";
    }

}