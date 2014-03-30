<?hh // strict
namespace traitorous\algebraic;

interface Applicative<A> extends Functor<A> {

    public function ap<B, C>(Applicative<B> $other): Applicative<C>;

}