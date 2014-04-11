<?hh // strict
namespace traitorous\outlaw;

interface Droppable<T, Tself> {

    public function drop(int $n): this;

    public function dropWhile((function(T): bool) $f): Tself;

}