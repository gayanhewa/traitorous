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

final class More<T> implements Finishable<T> {

    public function __construct(private T $_x): void { }

    public function add(Finishable<T> $other): Finishable<T> {
        invariant($this->_x instanceof Add, "Expected More to contain an Add");
        return $other->cata(
            ($y) ==> new Done($this->_x->add($y)),
            ($y) ==> new More($this->_x->add($y))
        );
    }

    public function ap<Tb, Tc>(Applicative<Tb> $next): Applicative<Tc> {
        // UNSAFE
        return $next->cata(
            ($y) ==> {
                $f = $this->_x; /* @var callable $f */
                return new Done($f($y));
            },
            ($y) ==> {
                $f = $this->_x; /* @var callable $f */
                return new More($f($y));
            }
        );
    }

    public function map<Tb>((function(T): Tb) $f): Finishable<Tb> {
        return new More($f($this->_x));
    }

    public function flatMap<Tb>((function(T): Monad<Tb>) $f): Finishable<Tb> {
        $result = $f($this->_x);
        invariant($result instanceof Finishable, "Expected to return a Finishable<Tb>");
        return $result;
    }

    public function zero(): this {
        invariant($this->_x instanceof Zero, "Expected More to contain an Zero");
        return new More($this->_x->zero());
    }

    public function equals(Finishable<T> $other): bool {
        invariant($this->_x instanceof Eq, "Expected More to contain an Eq");
        return $other->cata(
            ($y) ==> false,
            ($y) ==> $this->_x->equals($y)
        );
    }

    public function getEnumKey(): int {
        return Finishable::MORE;
    }

    public function compare(Finishable<T> $other): int {
        invariant($this->_x instanceof Ord, "Expected More to contain an Ord");
        return $other->cata(
            ($y) ==> Ord::LESS,
            ($y) ==> $this->_x->compare($y)
        );
    }

    public function show(): string {
        invariant($this->_x instanceof Show, "Expected More to contain a Show");
        $inner = $this->_x->show();
        invariant(is_string($inner), "Expected a string");
        return "More({$inner})";
    }

    public function unbox(): T {
        return $this->_x;
    }

    public function cata<Tb>((function(T): Tb) $done, (function(T): Tb) $more): Tb {
        return $more($this->_x);
    }

}