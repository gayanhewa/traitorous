<?hh // strict
namespace traitorous\algebraic;

interface Functor<T> {

    public function map<Tb>((function(T): Tb) $f): Functor<Tb>;

}