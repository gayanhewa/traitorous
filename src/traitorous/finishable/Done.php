<?hh // strict
namespace traitorous\finishable;

use traitorous\algebraic\Applicative;
use traitorous\algebraic\Monad;
use traitorous\Finishable;
use traitorous\outlaw\Add;
use traitorous\outlaw\Eq;
use traitorous\outlaw\Ord;
use traitorous\outlaw\Show;
use traitorous\outlaw\Zero;

final class Done<T> implements Finishable<T> {

    public function __construct(private T $_x) { }

    public function add(Finishable<T> $other): Finishable<T> {
        invariant($this->_x instanceof Add, "Expected Done to contain an Add");
        return $other->cata(
            ($y) ==> new Done($this->_x->add($y)),
            ($y) ==> new Done($this->_x->add($y))
        );
    }

    public function ap<Tb, Tc>(Applicative<Tb> $next): Finishable<Tc> {
        // UNSAFE
        return $this;
    }

    public function map<Tb>((function(T): Tb) $f): Finishable<Tb> {
        // UNSAFE
        return $this;
    }

    public function flatMap<Tb>((function(T): Monad<Tb>) $f): Finishable<Tb> {
        // UNSAFE
        return $this;
    }

    public function zero(): Finishable<T> {
        invariant($this->_x instanceof Zero, "Expected Done to contain an Zero");
        return new More($this->_x->zero());
    }

    public function equals(Finishable<T> $other): bool {
        invariant($this->_x instanceof Eq, "Expected Done to contain an Eq");
        return $other->cata(
            ($y) ==> $this->_x->equals($y),
            ($y) ==> false
        );
    }

    public function getEnumKey(): int {
        return Finishable::DONE;
    }

    public function compare(Finishable<T> $other): int {
        invariant($this->_x instanceof Ord, "Expected Done to contain an Ord");
        return $other->cata(
            ($y) ==> $this->_x->compare($y),
            ($y) ==> Ord::GREATER
        );
    }

    public function show(): string {
        invariant($this->_x instanceof Show, "Expected Done to contain a Show");
        $inner = $this->_x->show();
        invariant(is_string($inner), "Expected a string");
        return "Done({$inner})";
    }

    public function unbox(): T {
        return $this->_x;
    }

    public function cata<Tb>((function(T): Tb) $done, (function(T): Tb) $more): Tb {
        return $done($this->_x);
    }

}