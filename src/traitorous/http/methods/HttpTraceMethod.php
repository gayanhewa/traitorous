<?hh // strict
namespace traitorous\http\methods;

use traitorous\http\HttpMethod;

final class HttpTraceMethod implements HttpMethod {

    public function __toString(): string {
        return "TRACE";
    }

}