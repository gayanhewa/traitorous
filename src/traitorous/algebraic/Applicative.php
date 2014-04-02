<?hh // strict
namespace traitorous\algebraic;

interface Applicative<T> extends Functor<T> {

    public function ap<Tb, Tc>(Applicative<Tb> $other): Applicative<Tc>;

}