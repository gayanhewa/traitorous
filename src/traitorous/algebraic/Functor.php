<?hh // strict
namespace traitorous\algebraic;

interface Functor<A> {

    public function map<B>((function(A): B) $f): Functor<B>;

}