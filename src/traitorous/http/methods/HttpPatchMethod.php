<?hh // strict
namespace traitorous\http\methods;

use traitorous\http\HttpMethod;

final class HttpPatchMethod implements HttpMethod {

    public function __toString(): string {
        return "PATCH";
    }

}