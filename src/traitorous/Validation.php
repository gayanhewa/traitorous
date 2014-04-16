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
use traitorous\outlaw\Invertable;
use traitorous\option\ProjectableToOption;
use traitorous\either\ProjectableToEither;

interface Validation<Te, Ts> extends Functor<Ts>,
                                     Applicative<Ts>,
                                     Monad<Ts>,
                                     SemiGroup<Validation<Te, Ts>>,
                                     Eq<Validation<Te, Ts>>,
                                     Ord<Validation<Te, Ts>>,
                                     Show,
                                     LeftMappable<Te>,
                                     KeyedEnum,
                                     Invertable<Validation<Ts, Te>>,
                                     ProjectableToOption<Ts>,
                                     ProjectableToEither<Ts>
{

    const FAILURE = 0;
    const SUCCESS = 1;

    public function map<Tb>((function(Ts): Tb) $f): Validation<Te, Tb>;

    public function ap<Tb, Tc>(Applicative<Tb> $other): Validation<Te, Tc>;

    public function flatMap<Tb>((function(Ts): Monad<Tb>) $f): Validation<Te, Tb>;

    public function cata<Tb>((function(Te): Tb) $failure,
                             (function(Ts): Tb) $success): Tb;

}