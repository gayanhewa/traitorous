<?hh // decl
namespace traitorous\matcher\string;

use traitorous\matcher\StringMatcher;

final class StringRegexMatcher implements StringMatcher {

    public function __construct(private $_regex): void { }

    public function match(string $string): bool {
        return preg_match($this->_regex, $string) === 1;
    }
}