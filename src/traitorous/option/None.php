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
use traitorous\Either;
use traitorous\either\Left;
use traitorous\either\Right;
use traitorous\Validation;
use traitorous\validation\Success;
use traitorous\validation\Failure;

final class None<T> implements Option<T> {

    public function getEnumKey(): int {
        return Option::NONE;
    }

    public function add(Option<T> $other): Option<T> {
        return $other;
    }

    public function zero(): Option<T> {
        return $this;
    }

    public function map<Tb>((function(T): Tb) $f): Option<Tb> {
        // UNSAFE
        return $this;
    }

    public function ap<Tb, Tc>(Applicative<Tb> $other): Option<Tc> {
        // UNSAFE
        return $this;
    }

    public function orThis(Alternative<T> $other): Option<T> {
        invariant($other instanceof Option, "Expected Option<T>");
        return $other;
    }

    public function orElse((function(): Alternative<T>) $other): Option<T> {
        $result = $other();
        invariant($result instanceof Option, "Expected Option<T>");
        return $result;
    }

    public function flatMap<Tb>((function(T): Monad<Tb>) $f): Option<Tb> {
        // UNSAFE
        return $this;
    }

    public function mplus(MonadPlus<T> $other): Option<T> {
        invariant($other instanceof Option, "Expected an Option<T>");
        return $other;
    }

    public function toRight<Ta>((function():Ta) $left): Either<Ta, T> {
        return new Left($left());
    }

    public function toLeft<Ta>((function():Ta) $right): Either<T, Ta> {
        return new Right($right());
    }

    public function toSuccess<Ta>((function():Ta) $failure): Validation<Ta, T> {
        return new Failure($failure());
    }

    public function toFailure<Ta>((function():Ta) $success): Validation<T, Ta> {
        return new Success($success());
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

    public function getOrElse((function(): T) $f): T {
        return $f();
    }

    public function getOrDefault(T $default): T {
        return $default;
    }

    public function filter((function(T): bool) $predicate): Option<T> {
        return $this;
    }

    public function equals(Option<T> $other): bool {
        return $other->cata(
            (  ) ==> true,
            ($n) ==> false
        );
    }

    public function compare(Option<T> $other): int {
        return $other->cata(
            (  ) ==> Ord::EQUAL,
            ($_) ==> Ord::LESS
        );
    }

    public function cata<Tb>((function(): Tb) $none, (function(T): Tb) $some): Tb {
        return $none();
    }
}