<?hh // strict
namespace traitorous\http\methods;

use traitorous\http\HttpMethod;

final class HttpOptionsMethod implements HttpMethod {

    public function __toString(): string {
        return "OPTIONS";
    }

}