<?hh // strict
namespace traitorous\http\methods;

use traitorous\http\HttpMethod;

final class HttpDeletetMethod implements HttpMethod {

    public function __toString(): string {
        return "DELETE";
    }

}