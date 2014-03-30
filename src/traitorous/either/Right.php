<?hh // strict
namespace traitorous\either;

use traitorous\algebraic\Applicative;
use traitorous\algebraic\MonadOps;
use traitorous\Either;
use traitorous\outlaw\Eq;
use traitorous\outlaw\Ord;

final class Right<L, R> implements Either<L, R> {

    public function __construct(const private $_inner) { }

    public function ap<B, C>(Applicative<B> $next): Applicative<C> {
        return $next->map($this->_inner);
    }

    public function equals(Eq $other): bool {
        return $other->cata(
            ($_) ==> false,
            ($n) ==> $this->_inner->equals($n)
        );
    }

    public function map<B>((function(A): B) $f) {
        return new Right($f($this->_inner));
    }

    public function leftMap<T>((function(A): T) $f): Either<T, R> {
        return $this;
    }

    public function getEnumKey(): int {
        return Either::RIGHT;
    }

    public function flatMap<B>((function(A): Either<L, B>) $f): Either<L, B> {
        return $f($this->_inner);
    }

    public function compare(Ord $other): int {
        return $other->cata(
            ($_) ==> Ord::GREATER,
            ($n) ==> $this->_inner->compare($n)
        );
    }

    public function getOrElse((function(): A) $f): A {
        return $this->_inner;
    }

    public function getOrDefault(A $default): A {
        return $this->_inner;
    }

    public function show(): string {
        return "Right({$this->_inner})";
    }

    public function cata<B>((function(L): B) $left, (function(R): B) $right): B {
        return $right($this->_inner);
    }

}