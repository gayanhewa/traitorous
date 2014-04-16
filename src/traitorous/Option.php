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
use traitorous\either\ProjectableToEither;
use traitorous\validation\ProjectableToValidation;

interface Option<T> extends SemiGroup<Option<T>>,
                            Monoid<Option<T>>,
                            Functor<T>,
                            Applicative<T>,
                            Alternative<T>,
                            Monad<T>,
                            MonadPlus<T>,
                            Eq<Option<T>>,
                            Ord<Option<T>>,
                            Show,
                            Container,
                            Unwrappable<T>,
                            Filterable<T, Option<T>>,
                            KeyedEnum,
                            ProjectableToEither<T>,
                            ProjectableToValidation<T>

{
    const NONE = 0;
    const SOME = 1;

    public function map<Tb>((function(T): Tb) $f): Option<Tb>;

    public function ap<Tb, Tc>(Applicative<Tb> $other): Option<Tc>;

    public function orThis(Alternative<T> $other): Option<T>;

    public function orElse((function(): Alternative<T>) $f): Option<T>;

    public function flatMap<Tb>((function(T): Monad<Tb>) $f): Option<Tb>;

    public function mplus(MonadPlus<T> $other): Option<T>;

    public function cata<Tb>((function(): Tb) $none, (function(T): Tb) $some): Tb;
}
