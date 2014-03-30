<?hh // strict
namespace traitorous\algebraic;

use traitorous\outlaw\Zero;

interface MonadPlus<A> extends Monad<A>, Zero {

    public function mplus(MonadPlus<A> $other): MonadPlus<A>;

}