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

interface Validation<Te, Ts> extends Functor<Ts>,
                                     Applicative<Ts>,
                                     Monad<Ts>,
                                     SemiGroup,
                                     Eq,
                                     Ord,
                                     Show,
                                     LeftMappable<Te>,
                                     KeyedEnum
{

    const FAILURE = 0;
    const SUCCESS = 1;

    public function cata<Tb>((function(Te): Tb) $failure,
                             (function(Ts): Tb) $success): \Tb;

}