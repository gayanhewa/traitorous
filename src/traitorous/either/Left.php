<?hh // strict
namespace traitorous\either;

use traitorous\algebraic\Applicative;
use traitorous\algebraic\Monad;
use traitorous\Either;
use traitorous\outlaw\Eq;
use traitorous\outlaw\Ord;
use traitorous\outlaw\Show;
use traitorous\Option;
use traitorous\option\None;
use traitorous\Validation;
use traitorous\validation\Success;
use traitorous\validation\Failure;

final class Left<Tl, Tr> implements Either<Tl, Tr> {

    public function __construct(private Tl $_inner) { }

    public function ap<Tb, Tc>(Applicative<Tb> $next): Either<Tl, Tc> {
        // UNSAFE
        return $next;
    }

    public function equals(Either<Tl, Tr> $other): bool {
        if ($this->_inner instanceof Eq) {
            return $other->cata(
                ($n) ==> $this->_inner->equals($n),
                ($_) ==> false
            );
        } else {
            return $other->cata(
                ($n) ==> $this->_inner === $n,
                ($_) ==> false
            );
        }
    }

    public function map<Tb>((function(Tr): Tb) $f): Either<Tl, Tb> {
        // UNSAFE
        return $this;
    }

    public function leftMap<Tb>((function(Tl): Tb) $f): Either<Tb, Tr> {
        return new Left($f($this->_inner));
    }

    public function getEnumKey(): int {
        return Either::LEFT;
    }

    public function flatMap<Tb>((function(Tr): Monad<Tb>) $f): Either<Tl, Tb> {
        // UNSAFE
        return $this;
    }

    public function compare(Either<Tl, Tr> $other): int {
        invariant($this->_inner instanceof Ord, "Expected Left to contain an Eq");
        return $other->cata(
            ($n) ==> $this->_inner->compare($n),
            ($_) ==> Ord::LESS
        );
    }

    public function invert(): Either<Tr, Tl> {
        return new Right($this->_inner);
    }

    public function toOption(): Option<Tr> {
        return new None();
    }

    public function toSuccess<Ta>((function():Ta) $f): Validation<Ta, Tr> {
        return new Failure($f());
    }

    public function toFailure<Ta>((function():Ta) $s): Validation<Tr, Ta> {
        return new Success($s());
    }

    public function getOrElse((function(): Tr) $f): Tr {
        return $f();
    }

    public function getOrDefault(Tr $default): Tr {
        return $default;
    }

    public function show(): string {
        invariant($this->_inner instanceof Show, "Expected either to contain a Show");
        $inner = $this->_inner->show();
        invariant(is_string($inner), "Expected a string");
        return "Left({$inner})";
    }

    public function cata<Tb>((function(Tl): Tb) $left, (function(Tr): Tb) $right): Tb {
        return $left($this->_inner);
    }

}