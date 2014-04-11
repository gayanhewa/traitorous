<?hh // strict
namespace traitorous\algebraic;

use traitorous\outlaw\Zero;

interface MonadPlus<T> extends Monad<T>, Zero<MonadPlus<T>> {

    public function mplus(MonadPlus<T> $other): MonadPlus<T>;

}