<?hh // strict
namespace traitorous\matcher\string;

use traitorous\matcher\StringMatcher;

final class StringLiteralMatcher implements StringMatcher {

    public function __construct(private $_string): void { }

    public function match(string $string): bool {
        return $string === $this->_string;
    }
}