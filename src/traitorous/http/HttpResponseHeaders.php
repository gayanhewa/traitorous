<?hh // decl
namespace traitorous\http;

use traitorous\http\headers\HttpResponseHeader;

final class HttpResponseHeaders {

    private static bool $_initialized = false;

    public function __construct() {
        if (self::$_initialized) {
            throw new \Exception(
                "You are only allowed to initialize this object once. " .
                "Please practice good dependency injection."
            );
        } else {
            self::$_initialized = true;
        }
    }

    public function areSent(): bool {
        return headers_sent();
    }

    public function set(HttpResponseHeader $header, bool $replace = true): void {
        $key   = $header->getKey();
        $value = $header->getValue();
        header("{$key}: {$value}", $replace);
    }

    public function remove(HttpResponseHeader $header): void {
        remove_header($header->getKey());
    }

}