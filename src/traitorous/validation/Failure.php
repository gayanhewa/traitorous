<?hh // strict
namespace traitorous\validation;

use traitorous\algebraic\Applicative;
use traitorous\algebraic\Monad;
use traitorous\outlaw\Add;
use traitorous\outlaw\Eq;
use traitorous\outlaw\Ord;
use traitorous\outlaw\Show;
use traitorous\Validation;
use traitorous\validation\Success;
use traitorous\Option;
use traitorous\option\None;
use traitorous\Either;
use traitorous\either\Left;
use traitorous\either\Right;

final class Failure<Te, Ts> implements Validation<Te, Ts> {

    public function __construct(private Te $_x): void { }

    public function map<Tb>((function(Ts): Tb) $f): Validation<Te, Tb> {
        // UNSAFE
        return $this;
    }

    public function ap<Tb, Tc>(Applicative<Tb> $next): Validation<Te, Tc> {
        // UNSAFE
        return $this;
    }

    public function flatMap<Tb>((function(Ts): Monad<Tb>) $f): Validation<Te, Tb> {
        // UNSAFE
        return $this;
    }

    public function leftMap<Tb>((function(Te): Tb) $f): Validation<Tb, Ts> {
        return new Failure($f($this->_x));
    }

    public function equals(Validation<Te, Ts> $other): bool {
        if ($this->_x instanceof Eq) {
            return $this->cata(
                ($y) ==> $this->_x->equals($y),
                ($y) ==> false
            );
        } else {
            return $this->cata(
                ($y) ==> $this->_x === $y,
                ($y) ==> false
            );
        }
    }

    public function getEnumKey(): int {
        return Validation::FAILURE;
    }

    public function compare(Validation<Te, Ts> $other): int {
        invariant($this->_x instanceof Ord, "Expected to contain an Eq");
        return $this->cata(
            ($y) ==> $this->_x->compare($y),
            ($y) ==> Ord::LESS
        );
    }

    public function invert(): Validation<Ts, Te> {
        return new Success($this->_x);
    }

    public function toOption(): Option<Ts> {
        return new None();
    }

    public function toRight<Ta>((function():Ta) $left): Either<Ta, Ts> {
        return new Left($left());
    }

    public function toLeft<Ta>((function():Ta) $right): Either<Ts, Ta> {
        return new Right($right());
    }

    public function show(): string {
        invariant($this->_x instanceof Show, "Expected either to contain a Show");
        $inner = $this->_x->show();
        invariant(is_string($inner), "Expected a string");
        return "Failure({$inner})";
    }

    public function add(Validation<Te, Ts> $other): Validation<Te, Ts> {
        invariant($this->_x instanceof Add, "Expected to contain an Eq");
        return $this->cata(
            ($y) ==> new Failure($this->_x->add($y)),
            ($y) ==> new Success($this->_x->add($y))
        );
    }

    public function cata<Tb>((function(Te): Tb) $failure,
                             (function(Ts): Tb) $success): Tb
    {
        return $failure($this->_x);
    }

}