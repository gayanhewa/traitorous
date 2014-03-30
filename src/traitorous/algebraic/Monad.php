<?hh // strict
namespace traitorous\algebraic;

interface Monad<A> extends Applicative<A> {

    public function flatMap<B>((function(A): Monad<B>) $f): Monad<B>;

}