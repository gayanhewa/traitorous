<?hh // strict
namespace traitorous\option;

use traitorous\algebraic\Alternative;
use traitorous\algebraic\Applicative;
use traitorous\algebraic\Monad;
use traitorous\algebraic\MonadOps;
use traitorous\algebraic\MonadPlus;
use traitorous\Option;
use traitorous\outlaw\Add;
use traitorous\outlaw\Eq;
use traitorous\outlaw\Ord;

final class None<A> implements Option<A> {

    public function getEnumKey(): int {
        return Option::NONE;
    }

    public function add(Add $other): Option<A> {
        return $other;
    }

    public function zero(): Option<A> {
        return $this;
    }

    public function map<B>((function(A): B) $f): Option<B> {
        return $this;
    }

    public function ap<B, C>(Applicative<B> $other): Option<C> {
        return $this;
    }

    public function orThis(Alternative<A> $other): Option<A> {
        return $other;
    }

    public function orElse((function(): Alternative<A>) $other): Option<A> {
        return $other();
    }

    public function flatMap<B>((function(A): Option<B>) $f): Option<B> {
        return $this;
    }

    public function mplus(MonadPlus<A> $other): Option<A> {
        return $other;
    }

    public function show(): string {
        return "None";
    }

    public function length(): int {
        return 0;
    }

    public function isEmpty(): bool {
        return true;
    }

    public function nonEmpty(): bool {
        return false;
    }

    public function getOrElse((function(): A) $f): A {
        return $f();
    }

    public function getOrDefault(\A $default): A {
        return $default;
    }

    public function filter((function(A): bool) $predicate): Option<A> {
        return $this;
    }

    public function equals(Eq $other): bool {
        return $other->cata(
            (  ) ==> true,
            ($n) ==> false
        );
    }

    public function compare(Ord $other): int {
        return $other->cata(
            (  ) ==> Ord::EQUAL,
            ($_) ==> Ord::LESS
        );
    }

    public function cata<B>((function(): B) $none, (function(A): B) $some) {
        return $none();
    }
}