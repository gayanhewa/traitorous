<?php
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

interface Either<L, R> extends Functor<R>,
                               Applicative<R>,
                               Monad<R>,
                               Eq,
                               Ord,
                               Show,
                               LeftMappabe<L>,
                               Unwrappable<R>,
                               KeyedEnum
{
    const LEFT  = 0;
    const RIGHT = 1;

    public function cata<B>((function(L): B) $left, (function(R): B) $right): B;
}