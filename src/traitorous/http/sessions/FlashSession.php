<?hh // strict
namespace traitorous\http\sessions;

use traitorous\http\HttpRequest;
use traitorous\http\Session;

final class FlashSession extends Session<FlashSession> {

    public function cata<T>((function(): T) $s, (function(): T) $f): T {
        return $f();
    }

    public static function fromRequest(string $secret, HttpRequest $request): FlashSession {
        return new FlashSession($secret, parent::_fromRequest("flash", $secret, $request));
    }

}