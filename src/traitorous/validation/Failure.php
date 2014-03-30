<?hh // strict
namespace traitorous\validation;

use traitorous\algebraic\Applicative;
use traitorous\algebraic\MonadOps;
use traitorous\outlaw\Add;
use traitorous\outlaw\Eq;
use traitorous\outlaw\Ord;
use traitorous\Success;
use traitorous\Validation;

final class Failure<E, S> implements Validation<E, S> {

    public function __construct(private $_x): void { }

    public function map<B>((function(A): B) $f): Validation<E, B> {
        return $this;
    }

    public function ap<B, C>(Applicative<B> $next): Validation<E, C> {
        return $this;
    }

    public function flatMap<B>((function(A): Validation<E, B>) $f): Validation<E, B> {
        return $this;
    }

    public function leftMap<T>((function(A): T) $f): Validation<T, S> {
        return new Failure($f($this->_x));
    }

    public function equals(Eq $other): bool {
        return $this->cata(
            ($y) ==> $this->_x->equals($y),
            ()   ==> false
        );
    }

    public function getEnumKey(): int {
        return Validation::FAILURE;
    }

    public function compare(Ord $other): int {
        return $this->cata(
            ($y) ==> $this->_x->compare($y),
            ()   ==> Ord::LESS
        );
    }

    public function show(): string {
        return "Failure({$this->_x->show()})";
    }

    public function cata<A>((function(E): A) $failure,
                            (function(S): A) $success): A
    {
        return $failure($this->_x);
    }

    public function add(Add $other): this {
        return $this->cata(
            ($y) ==> new Failure($this->_x->add($y)),
            ($y) ==> new Success($this->_x->add($y))
        );
    }

}