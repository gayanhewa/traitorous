<?hh // strict
namespace traitorous\http\methods;

use traitorous\http\HttpMethod;

final class HttpPostMethod implements HttpMethod {

    public function __toString(): string {
        return "POST";
    }

}