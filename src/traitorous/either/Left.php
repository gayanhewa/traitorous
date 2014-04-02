<?hh // strict
namespace traitorous\either;

use traitorous\algebraic\Applicative;
use traitorous\algebraic\MonadOps;
use traitorous\Either;
use traitorous\outlaw\Eq;
use traitorous\outlaw\Ord;

final class Left<Tl, Tr> implements Either<Tl, Tr> {

    public function __construct(private \Tl $_inner) { }

    public function ap<Tb, Tc>(Applicative<Tb> $next): Applicative<Tc> {
        return $next;
    }

    public function equals(Eq $other): bool {
        return $other->cata(
            ($n) ==> $this->_inner->equals($n),
            ($_) ==> false
        );
    }

    public function map<Tb>((function(Tr): Tb) $f): Either<Tl, Tb> {
        return $this;
    }

    public function leftMap<Tb>((function(Tr): Tb) $f): Either<Tl, Tb> {
        return new Left($f($this->_inner));
    }

    public function getEnumKey(): int {
        return Either::LEFT;
    }

    public function flatMap<Tb>((function(Tr): Either<Tl, Tb>) $f): Either<Tl, Tb> {
        return $this;
    }

    public function compare(Ord $other): int {
        return $other->cata(
            ($n) ==> $this->_inner->compare($n),
            ($_) ==> Ord::LESS
        );
    }

    public function getOrElse((function(): Tr) $f): Tr {
        return $f();
    }

    public function getOrDefault(\Tr $default): Tr {
        return $default;
    }

    public function show(): string {
        return "Left({$this->_inner})";
    }

    public function cata<Tb>((function(Tl): Tb) $left, (function(Tr): Tb) $right): Tb {
        return $left($this->_inner);
    }

}