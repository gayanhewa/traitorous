<?hh // strict
namespace traitorous\either;

use traitorous\algebraic\Applicative;
use traitorous\algebraic\MonadOps;
use traitorous\Either;
use traitorous\outlaw\Eq;
use traitorous\outlaw\Ord;

final class Right<Tl, Tr> implements Either<Tl, Tr> {

    public function __construct(private \Tr $_inner) { }

    public function ap<Tb, Tc>(Applicative<Tb> $next): Applicative<Tc> {
        return $next->map($this->_inner);
    }

    public function equals(Eq $other): bool {
        return $other->cata(
            ($_) ==> false,
            ($n) ==> $this->_inner->equals($n)
        );
    }

    public function map<Tb>((function(Tr): Tb) $f): Either<Tl, Tb> {
        return new Right($f($this->_inner));
    }

    public function leftMap<Tb>((function(Tr): Tb) $f): Either<Tl, Tb> {
        return $this;
    }

    public function getEnumKey(): int {
        return Either::RIGHT;
    }

    public function flatMap<Tb>((function(Tr): Either<Tl, Tb>) $f): Either<Tl, Tb> {
        return $f($this->_inner);
    }

    public function compare(Ord $other): int {
        return $other->cata(
            ($_) ==> Ord::GREATER,
            ($n) ==> $this->_inner->compare($n)
        );
    }

    public function getOrElse((function(): Tr) $f): Tr {
        return $this->_inner;
    }

    public function getOrDefault(\Tr $default): Tr {
        return $this->_inner;
    }

    public function show(): string {
        return "Right({$this->_inner})";
    }

    public function cata<Tb>((function(Tl): Tb) $left, (function(Tr): Tb) $right): Tb {
        return $right($this->_inner);
    }

}