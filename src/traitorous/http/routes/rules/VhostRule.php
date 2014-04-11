<?hh // strict
namespace traitorous\routes\rules;

use traitorous\http\routes\HttpRouteRule;
use traitorous\http\HttpRequest;
use traitorous\matcher\StringMatcher;

final class VhostRule implements HttpRouteRule {

    public function __construct(private StringMatcher $_matcher): void { }

    public function validate(HttpRequest $request): bool {
        return $request
            ->getHeader("Host")
            ->filter(($host) ==> $this->_matcher->match($host))
            ->nonEmpty();
    }
}