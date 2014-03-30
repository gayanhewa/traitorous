<?hh // strict
namespace traitorous\outlaw;

interface Droppable<A> {

    public function drop(int $n): this;

    public function dropWhile((funciton(A): bool) $f): this;

}