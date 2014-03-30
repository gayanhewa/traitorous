<?hh // strict
namespace traitorous\http\routes;

use traitorous\http\HttpRequest;

interface HttpRouteRule {

    public function validate(HttpRequest $request): bool;

}