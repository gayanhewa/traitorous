<?hh // strict
namespace traitorous\http\routes\rules;

use traitorous\http\routes\HttpRouteRule;
use traitorous\http\HttpRequest;

final class HttpRouteRules implements HttpRouteRule {

    public function __construct(private Vector<HttpRouteRule> $_rules): void { }

    public function validate(HttpRequest $request): bool {
        return array_reduce(
            $this->_rules->toArray(),
            (bool $status, HttpRouteRule $rule) ==> {
                return $status && $rule->validate($request);
            },
            true
        );
    }

}