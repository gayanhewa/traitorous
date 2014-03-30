<?hh // strict
namespace traitorous\either;

use traitorous\algebraic\Applicative;
use traitorous\algebraic\MonadOps;
use traitorous\Either;
use traitorous\outlaw\Eq;
use traitorous\outlaw\Ord;

final class Left<L, R> implements Either<L, R> {

    public function __construct(const private $_inner) { }

    public function ap<B, C>(Applicative<B> $next): Applicative<C> {
        return $next;
    }

    public function equals(Eq $other): bool {
        return $other->cata(
            ($n) ==> $this->_inner->equals($n),
            ($_) ==> false
        );
    }

    public function map<B>((function(A): B) $f): Either<L, B> {
        return $this;
    }

    public function leftMap<T>((function(A): T) $f): Either<T, R> {
        return new Left($f($this->_inner));
    }

    public function getEnumKey(): int {
        return Either::LEFT;
    }

    public function flatMap<B>((function(A): Either<L, B>) $f): Either<L, B> {
        return $this;
    }

    public function compare(Ord $other): int {
        return $other->cata(
            ($n) ==> $this->_inner->compare($n),
            ($_) ==> Ord::LESS
        );
    }

    public function getOrElse((function(): A) $f): A {
        return $f();
    }

    public function getOrDefault(A $default): A {
        return $default;
    }

    public function show(): string {
        return "Left({$this->_inner})";
    }

    public function cata<B>((function(L): B) $left, (function(R): B) $right): B {
        return $left($this->_inner);
    }

}