<?hh // strict
namespace traitorous\http\routes\rules;

use traitorous\http\routes\HttpRouteRule;
use traitorous\http\HttpRequest;
use traitorous\matcher\StringMatcher;

final class PathRule implements HttpRouteRule {

    public function __construct(private StringMatcher $_matcher): void { }

    public function validate(HttpRequest $request): bool {
        return $request->getPath()->filter((string $path) ==> {
            return $this->_matcher->match($path);
        })->nonEmpty();
    }
}