<?hh // strict
namespace traitorous;

use traitorous\algebraic\Applicative;
use traitorous\algebraic\Functor;
use traitorous\algebraic\Monad;
use traitorous\algebraic\SemiGroup;
use traitorous\outlaw\Eq;
use traitorous\outlaw\KeyedEnum;
use traitorous\outlaw\Ord;
use traitorous\outlaw\Show;
use traitorous\outlaw\LeftMappable;

interface Validation<E, S> extends Functor<S>,
                                   Applicative<S>,
                                   Monad<S>,
                                   SemiGroup,
                                   Eq,
                                   Ord,
                                   Show,
                                   LeftMappable<E>,
                                   KeyedEnum
{

    const FAILURE = 0;
    const SUCCESS = 1;

    public function cata<A>((function(E): A) $failure,
                            (function(S): A) $success): A;

}