<?hh // strict
namespace traitorous;

use traitorous\algebraic\Applicative;
use traitorous\algebraic\Functor;
use traitorous\algebraic\Monad;
use traitorous\outlaw\Eq;
use traitorous\outlaw\KeyedEnum;
use traitorous\outlaw\Ord;
use traitorous\outlaw\Show;
use traitorous\outlaw\LeftMappable;
use traitorous\outlaw\Unwrappable;

interface Either<Tl, Tr> extends Functor<Tr>,
                                 Applicative<Tr>,
                                 Monad<Tr>,
                                 Eq<Either<Tl, Tr>>,
                                 Ord<Either<Tl, Tr>>,
                                 Show,
                                 LeftMappable<Tl>,
                                 Unwrappable<Tr>,
                                 KeyedEnum
{
    const LEFT  = 0;
    const RIGHT = 1;

    public function map<Tb>((function(Tr): Tb) $f): Either<Tl, Tb>;

    public function ap<Tb, Tc>(Applicative<Tb> $other): Either<Tl, Tc>;

    public function flatMap<Tb>((function(Tr): Monad<Tb>) $f): Either<Tl, Tb>;

    public function cata<Tb>((function(Tl): Tb) $left, (function(Tr): Tb) $right): Tb;
}