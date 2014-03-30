<?hh // strict
namespace traitorous\http\methods;

use traitorous\http\HttpMethod;

final class HttpGetMethod implements HttpMethod {

    public function __toString(): string {
        return "GET";
    }

}