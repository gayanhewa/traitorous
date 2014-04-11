<?hh // strict
namespace traitorous\either;

use traitorous\algebraic\Applicative;
use traitorous\algebraic\Monad;
use traitorous\Either;
use traitorous\outlaw\Eq;
use traitorous\outlaw\Ord;
use traitorous\outlaw\Show;

final class Left<Tl, Tr> implements Either<Tl, Tr> {

    public function __construct(private Tl $_inner) { }

    public function ap<Tb, Tc>(Applicative<Tb> $next): Applicative<Tc> {
        // UNSAFE
        return $next;
    }

    public function equals(Either<Tl, Tr> $other): bool {
        invariant($this->_inner instanceof Eq, "Expected Left to contain an Eq");
        return $other->cata(
            ($n) ==> $this->_inner->equals($n),
            ($_) ==> false
        );
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