<?hh // strict
namespace traitorous\finishable;

use traitorous\algebraic\Applicative;
use traitorous\algebraic\MonadOps;
use traitorous\Finishable;
use traitorous\outlaw\Add;
use traitorous\outlaw\Eq;
use traitorous\outlaw\Ord;

final class Done<T> implements Finishable<T> {

    public function __construct(private \T $_x) { }

    public function add(Add $other): Finishable<T> {
        return $other->cata(
            (Add $y) ==> new Done($this->_x->add($y)),
            (Add $y) ==> new Done($this->_x->add($y))
        );
    }

    public function ap<Tb, Tc>(Applicative<Tb> $next): Finishable<Tc> {
        return $this;
    }

    public function map<Tb>((function(T): Tb) $f): Finishable<Tb> {
        return $this;
    }

    public function flatMap<Tb>((function(T): Finishable<Tb>) $f): Finishable<Tb> {
        return $this;
    }

    public function zero(): Finishable<T> {
        return new More($this->_x->zero());
    }

    public function equals(Eq $other): bool {
        return $other->cata(
            (Add $y) ==> $this->_x->equals($y),
            ()       ==> false
        );
    }

    public function getEnumKey(): int {
        return Finishable::DONE;
    }

    public function compare(Ord $other): int {
        return $other->cata(
            (Add $y) ==> return $this->_x->compare($y),
            ()       ==> Ord::GREATER
        );
    }

    public function show(): string {
        return "Done({$this->_x->show()})";
    }

    public function unbox(): A {
        return $this->_x;
    }

    public function cata<Tb>((function(T): Tb) $done, (function(T): Tb) $more): Tb {
        return $done($this->_x);
    }

}