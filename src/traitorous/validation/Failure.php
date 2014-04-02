<?hh // strict
namespace traitorous\validation;

use traitorous\algebraic\Applicative;
use traitorous\algebraic\MonadOps;
use traitorous\outlaw\Add;
use traitorous\outlaw\Eq;
use traitorous\outlaw\Ord;
use traitorous\Success;
use traitorous\Validation;

final class Failure<Te, Ts> implements Validation<Te, Ts> {

    public function __construct(private \Te $_x): void { }

    public function map<Tb>((function(Ts): Tb) $f): Validation<Te, Tb> {
        return $this;
    }

    public function ap<Tb, Tc>(Applicative<Tb> $next): Validation<Te, Tc> {
        return $this;
    }

    public function flatMap<Tb>((function(Ts): Validation<Te, Tb>) $f): Validation<Te, Tb> {
        return $this;
    }

    public function leftMap<Tb>((function(Te): Tb) $f): Validation<Tb, Ts> {
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

    public function add(Add $other): this {
        return $this->cata(
            ($y) ==> new Failure($this->_x->add($y)),
            ($y) ==> new Success($this->_x->add($y))
        );
    }

    public function cata<Tb>((function(Te): Tb) $failure,
                             (function(Ts): Tb) $success): \Tb
    {
        return $failure($this->_x);
    }

}