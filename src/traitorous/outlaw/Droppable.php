<?hh // strict
namespace traitorous\outlaw;

interface Droppable<T> {

    public function drop(int $n): this;

    public function dropWhile((function(T): bool) $f): Droppable<T>;

}