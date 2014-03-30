<?hh // strict
namespace traitorous\validation;

use traitorous\algebraic\Applicative;
use traitorous\algebraic\MonadOps;
use traitorous\outlaw\Add;
use traitorous\outlaw\Eq;
use traitorous\outlaw\Ord;
use traitorous\Validation;

final class Success<E, S> implements Validation<E, S> {

    public function __construct(private $_x) { }

    public function map<B>((function(A): B) $f): Validation<E, B> {
        return new Success($f($this->_x));
    }

    public function ap<B, C>(Applicative<B> $next): Validation<E, C> {
        return $next->cata(
            () ==> $next,
            () ==> $next->map($this->_x)
        );
    }

    public function flatMap<B>((function(A): Validation<E, B>) $f): Validation<E, B> {
        return $f($this->_x);
    }

    public function leftMap<T>((function(A): T) $f): Validation<T, S> {
        return $this;
    }

    public function equals(Eq $other): bool {
        return $this->cata(
            ()   ==> false,
            ($y) ==> $this->_x->equals($y)
        );
    }

    public function getEnumKey(): int {
        return Validation::SUCCESS;
    }

    public function compare(Ord $other): int {
        return $this->cata(
            ()   ==> Ord::GREATER,
            ($y) ==> $this->_x->compare($y)
        );
    }

    public function show(): string {
        return "Success({$this->_x->show()})";
    }

    public function cata<A>((function(E): A) $failure,
                            (function(S): A) $success): A
    {
        return $success($this->_x);
    }

    public function add(Add $other): this {
        return $this->cata(
            ($y) ==> new Failure($this->_x->add($y)),
            ($y) ==> new Success($this->_x->add($y))
        );
    }

}