<?hh // strict
namespace traitorous\outlaw;

interface Takeable<T> {

    public function take(int $n): this;

    public function takeWhile((function(T): bool) $f): Takeable<T>;

}