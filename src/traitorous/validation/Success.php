<?hh // strict
namespace traitorous\validation;

use traitorous\algebraic\Applicative;
use traitorous\algebraic\MonadOps;
use traitorous\outlaw\Add;
use traitorous\outlaw\Eq;
use traitorous\outlaw\Ord;
use traitorous\Validation;

final class Success<Te, Ts> implements Validation<Te, Ts> {

    public function __construct(private \Ts $_x) { }

    public function map<Tb>((function(Ts): Tb) $f): Validation<Te, Tb> {
        return new Success($f($this->_x));
    }

    public function ap<Tb, Tc>(Applicative<Tb> $next): Validation<Te, Tc> {
        return $next->cata(
            () ==> $next,
            () ==> $next->map($this->_x)
        );
    }

    public function flatMap<Tb>((function(Ts): Validation<Te, Tb>) $f): Validation<Te, Tb> {
        return $f($this->_x);
    }

    public function leftMap<Tb>((function(Ts): Tb) $f): Validation<Tb, Ts> {
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

    public function add(Add $other): this {
        return $this->cata(
            ($y) ==> new Failure($this->_x->add($y)),
            ($y) ==> new Success($this->_x->add($y))
        );
    }

    public function cata<Tb>((function(Te): Tb) $failure,
                             (function(Ts): Tb) $success): \Tb
    {
        return $success($this->_x);
    }

}