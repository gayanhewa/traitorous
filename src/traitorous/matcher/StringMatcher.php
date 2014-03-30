<?hh // strict
namespace traitorous\matcher;

interface StringMatcher {

    public function match(string $string): bool;

}