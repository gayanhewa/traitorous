<?hh // strict
namespace traitorous\http\routes\rules;

use traitorous\http\routes\HttpRouteRule;
use traitorous\http\HttpRequest;

final class CatchAllRule implements HttpRouteRule {

    public function validate(HttpRequest $request): bool {
        return true;
    }

}