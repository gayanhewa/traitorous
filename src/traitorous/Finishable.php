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

interface Finishable<T> extends SemiGroup<Finishable<T>>,
                                Monoid<Finishable<T>>,
                                Functor<T>,
                                Applicative<T>,
                                Monad<T>,
                                Show,
                                Eq<Finishable<T>>,
                                Ord<Finishable<T>>,
                                Unboxable<T>,
                                KeyedEnum
{
    const DONE = 0;
    const MORE = 1;

    public function cata<Tb>((function(T): Tb) $done, (function(T): Tb) $more): Tb;
}