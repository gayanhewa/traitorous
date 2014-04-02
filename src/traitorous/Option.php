<?hh // strict
namespace traitorous;

use traitorous\algebraic\Alternative;
use traitorous\algebraic\Applicative;
use traitorous\algebraic\Functor;
use traitorous\algebraic\Monad;
use traitorous\algebraic\MonadPlus;
use traitorous\algebraic\Monoid;
use traitorous\algebraic\SemiGroup;
use traitorous\outlaw\Container;
use traitorous\outlaw\Eq;
use traitorous\outlaw\Filterable;
use traitorous\outlaw\KeyedEnum;
use traitorous\outlaw\Ord;
use traitorous\outlaw\Show;
use traitorous\outlaw\Unwrappable;

interface Option<T> extends SemiGroup,
                            Monoid,
                            Functor<T>,
                            Applicative<T>,
                            Alternative<T>,
                            Monad<T>,
                            MonadPlus<T>,
                            Eq,
                            Ord,
                            Show,
                            Container,
                            Unwrappable<T>,
                            Filterable<T>,
                            KeyedEnum

{
    const NONE = 0;
    const SOME = 1;

    public function cata<Tb>((function(): Tb) $none, (function(T): Tb) $some): \Tb;
}
