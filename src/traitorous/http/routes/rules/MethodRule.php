<?hh // strict
namespace traitorous\http\routes\rules;

use traitorous\http\HttpMethod;
use traitorous\http\routes\HttpRouteRule;
use traitorous\http\HttpRequest;

final class MethodRule implements HttpRouteRule {

    public function __construct(private HttpMethod $_method): void { }

    public function validate(HttpRequest $request): bool {
        return $request->getMethod()->filter((string $method) ==> {
            return $method === $this->_method->__toString();
        })->nonEmpty();
    }

}