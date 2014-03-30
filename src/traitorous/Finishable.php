<?hh // strict
namespace traitorous;

use traitorous\algebraic\Applicative;
use traitorous\algebraic\Functor;
use traitorous\algebraic\Monad;
use traitorous\algebraic\Monoid;
use traitorous\algebraic\SemiGroup;
use traitorous\outlaw\Eq;
use traitorous\outlaw\KeyedEnum;
use traitorous\outlaw\Ord;
use traitorous\outlaw\Show;
use traitorous\outlaw\Unboxable;

interface Finishable<A> extends SemiGroup,
                                Monoid,
                                Functor,
                                Applicative,
                                Monad,
                                Show,
                                Eq,
                                Ord,
                                Unboxable,
                                KeyedEnum
{
    const DONE = 0;
    const MORE = 1;

    public function cata<B>((function(A): B) $done, (function(A): B) $more): B;
}