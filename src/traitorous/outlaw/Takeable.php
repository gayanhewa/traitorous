<?hh // strict
namespace traitorous\outlaw;

interface Takeable<T, Tself> {

    public function take(int $n): Tself;

    public function takeWhile((function(T): bool) $f): Tself;

}