<?hh // strict
namespace traitorous\option;

use traitorous\algebraic\Alternative;
use traitorous\algebraic\Applicative;
use traitorous\algebraic\Monad;
use traitorous\algebraic\MonadPlus;
use traitorous\Option;
use traitorous\outlaw\Add;
use traitorous\outlaw\Eq;
use traitorous\outlaw\Ord;
use traitorous\outlaw\Show;
use traitorous\Either;
use traitorous\either\Left;
use traitorous\either\Right;
use traitorous\Validation;
use traitorous\validation\Success;
use traitorous\validation\Failure;

final class Some<T> implements Option<T> {

    public function __construct(private T $_inner): void { }

    public function getEnumKey(): int {
        return Option::SOME;
    }

    public function add(Option<T> $other): this {
        invariant($this->_inner instanceof Add, "Expected to contain an Add");
        return $other->cata(
            (  ) ==> $this,
            ($n) ==> new Some($this->_inner->add($n))
        );
    }

    public function zero(): Option<T> {
        return new None();
    }

    public function map<Tb>((function(T): Tb) $f): Option<Tb> {
        return new Some($f($this->_inner));
    }

    public function ap<Tb, Tc>(Applicative<Tb> $other): Option<Tc> {
        // UNSAFE
        return $other->map($this->_inner);
    }

    public function orThis(Alternative<T> $other): Option<T> {
        return $this;
    }

    public function orElse((function(): Alternative<T>) $other): Option<T> {
        return $this;
    }

    public function flatMap<Tb>((function(T): Monad<Tb>) $f): Option<Tb> {
        $result = $f($this->_inner);
        invariant($result instanceof Option, "Expected Option<T>");
        return $result;
    }

    public function mplus(MonadPlus<T> $other): this {
        return $this;
    }

    public function toRight<Ta>((function():Ta) $left): Either<Ta, T> {
        return new Right($this->_inner);
    }

    public function toLeft<Ta>((function():Ta) $right): Either<T, Ta> {
        return new Left($this->_inner);
    }

    public function toSuccess<Ta>((function():Ta) $failure): Validation<Ta, T> {
        return new Success($this->_inner);
    }

    public function toFailure<Ta>((function():Ta) $success): Validation<T, Ta> {
        return new Failure($this->_inner);
    }

    public function show(): string {
        invariant($this->_inner instanceof Show, "Expected either to contain a Show");
        $inner = $this->_inner->show();
        invariant(is_string($inner), "Expected a string");
        return "Some({$inner})";
    }

    public function length(): int {
        return 1;
    }

    public function isEmpty(): bool {
        return false;
    }

    public function nonEmpty(): bool {
        return true;
    }

    public function getOrElse((function(): T) $f): T {
        return $this->_inner;
    }

    public function getOrDefault(T $default): T {
        return $this->_inner;
    }

    public function filter((function(T): bool) $predicate): Option<T> {
        if ($predicate($this->_inner)) {
            return $this;
        } else {
            return new None();
        }
    }

    public function equals(Option<T> $other): bool {
        invariant($this->_inner instanceof Eq, "Expected to contain an Eq");
        return $other->cata(
            (  ) ==> false,
            ($n) ==> $this->_inner->equals($n)
        );
    }

    public function compare(Option<T> $other): int {
        invariant($this->_inner instanceof Ord, "Expected to contain an Eq");
        return $other->cata(
            (  ) ==> Ord::GREATER,
            ($n) ==> $this->_inner->compare($n)
        );
    }

    public function cata<Tb>((function(): Tb) $none, (function(T): Tb) $some): Tb {
        return $some($this->_inner);
    }
}