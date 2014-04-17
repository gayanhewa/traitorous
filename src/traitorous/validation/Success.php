<?hh // strict
namespace traitorous\validation;

use traitorous\algebraic\Applicative;
use traitorous\algebraic\Monad;
use traitorous\outlaw\Add;
use traitorous\outlaw\Eq;
use traitorous\outlaw\Ord;
use traitorous\outlaw\Show;
use traitorous\Validation;
use traitorous\Option;
use traitorous\option\Some;
use traitorous\option\None;
use traitorous\Either;
use traitorous\either\Left;
use traitorous\either\Right;

final class Success<Te, Ts> implements Validation<Te, Ts> {

    public function __construct(private Ts $_x) { }

    public function map<Tb>((function(Ts): Tb) $f): Validation<Te, Tb> {
        return new Success($f($this->_x));
    }

    public function ap<Tb, Tc>(Applicative<Tb> $next): Validation<Te, Tc> {
        invariant($next instanceof Validation, "Expected a Validation");
        // UNSAFE
        return $next->cata(
            ($x) ==> $next,
            ($x) ==> $next->map($this->_x)
        );
    }

    public function flatMap<Tb>((function(Ts): Monad<Tb>) $f): Validation<Te, Tb> {
        $result = $f($this->_x);
        invariant($result instanceof Validation, "Expected a Validation");
        return $result;
    }

    public function leftMap<Tb>((function(Te): Tb) $f): Validation<Tb, Ts> {
        // UNSAFE
        return $this;
    }

    public function equals(Validation<Te, Ts> $other): bool {
        if ($this->_x instanceof Eq) {
            return $this->cata(
                ($y) ==> false,
                ($y) ==> $this->_x->equals($y)
            );
        } else {
            return $this->cata(
                ($y) ==> false,
                ($y) ==> $this->_x === $y
            );
        }
    }

    public function getEnumKey(): int {
        return Validation::SUCCESS;
    }

    public function compare(Validation<Te, Ts> $other): int {
        invariant($this->_x instanceof Ord, "Expected to contain an Ord");
        return $this->cata(
            ($y) ==> Ord::GREATER,
            ($y) ==> $this->_x->compare($y)
        );
    }

    public function invert(): Validation<Ts, Te> {
        return new Failure($this->_x);
    }

    public function toOption(): Option<Ts> {
        return new Some($this->_x);
    }

    public function toRight<Ta>((function():Ta) $left): Either<Ta, Ts> {
        return new Right($this->_x);
    }

    public function toLeft<Ta>((function():Ta) $right): Either<Ts, Ta> {
        return new Left($this->_x);
    }

    public function show(): string {
        invariant($this->_x instanceof Show, "Expected either to contain a Show");
        $inner = $this->_x->show();
        invariant(is_string($inner), "Expected a string");
        return "Success({$inner})";
    }

    public function add(Validation<Te, Ts> $other): Validation<Te, Ts> {
        invariant($this->_x instanceof Add, "Expected to contain an Add");
        return $this->cata(
            ($y) ==> new Failure($this->_x->add($y)),
            ($y) ==> new Success($this->_x->add($y))
        );
    }

    public function cata<Tb>((function(Te): Tb) $failure,
                             (function(Ts): Tb) $success): Tb
    {
        return $success($this->_x);
    }

}