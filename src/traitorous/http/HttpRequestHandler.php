<?hh // strict
namespace traitorous\http;

use traitorous\http\HttpRequest;
use traitorous\http\routes\HttpRouteRule;
use traitorous\http\HttpResponse;

interface HttpRequestHandler {

    public function route(): HttpRouteRule;

    public function handle(HttpRequest $request): HttpResponse;

    public function apply(HttpRequest $request): HttpResponse;

}