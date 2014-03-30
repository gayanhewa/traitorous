<?hh // strict
namespace traitorous\http\methods;

use traitorous\http\HttpMethod;

final class HttpPutMethod implements HttpMethod {

    public function __toString(): string {
        return "PUT";
    }

}