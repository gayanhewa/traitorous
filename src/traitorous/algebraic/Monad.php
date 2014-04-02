<?hh // strict
namespace traitorous\algebraic;

interface Monad<T> extends Applicative<T> {

    public function flatMap<Tb>((function(T): Monad<Tb>) $f): Monad<Tb>;

}