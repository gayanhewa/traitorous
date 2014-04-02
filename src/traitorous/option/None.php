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

final class None<T> implements Option<T> {

    public function getEnumKey(): int {
        return Option::NONE;
    }

    public function add(Add $other): Option<A> {
        return $other;
    }

    public function zero(): Option<A> {
        return $this;
    }

    public function map<Tb>((function(T): Tb) $f): Option<Tb> {
        return $this;
    }

    public function ap<Tb, Tc>(Applicative<Tb> $other): Option<Tc> {
        return $this;
    }

    public function orThis(Alternative<T> $other): Option<T> {
        return $other;
    }

    public function orElse((function(): Alternative<T>) $other): Option<T> {
        return $other();
    }

    public function flatMap<Tb>((function(T): Option<Tb>) $f): Option<Tb> {
        return $this;
    }

    public function mplus(MonadPlus<T> $other): Option<T> {
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

    public function getOrElse((function(): T) $f): \T {
        return $f();
    }

    public function getOrDefault(\T $default): \T {
        return $default;
    }

    public function filter((function(T): bool) $predicate): Option<T> {
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

    public function cata<Tb>((function(): Tb) $none, (function(T): Tb) $some): \Tb {
        return $none();
    }
}