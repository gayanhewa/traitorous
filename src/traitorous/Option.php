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

interface Option<A> extends SemiGroup,
                            Monoid,
                            Functor<A>,
                            Applicative<A>,
                            Alternative<A>,
                            Monad<A>,
                            MonadPlus<A>,
                            Eq,
                            Ord,
                            Show,
                            Container<A>,
                            Unwrappable<A>,
                            Filterable<A>,
                            KeyedEnum

{
    const NONE = 0;
    const SOME = 1;

    public function cata<B>((function(): B) $none, (function(A): B) $some);
}
