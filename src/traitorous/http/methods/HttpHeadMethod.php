<?hh // strict
namespace traitorous\http\methods;

use traitorous\http\HttpMethod;

final class HttpHeadMethod implements HttpMethod {

    public function __toString(): string {
        return "HEAD";
    }

}