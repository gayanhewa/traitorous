<?hh // strict
namespace traitorous\finishable;

use traitorous\algebraic\Applicative;
use traitorous\algebraic\MonadOps;
use traitorous\Finishable;
use traitorous\outlaw\Add;
use traitorous\outlaw\Eq;
use traitorous\outlaw\Ord;

final class More<T> implements Finishable<T> {

    public function __construct(private \T $_x): void { }

    public function add(Add $other): this {
        return $other->cata(
            function(Add $y) { return new Done($this->_x->add($y)); },
            function(Add $y) { return new More($this->_x->add($y)); }
        );
    }

    public function ap<Tb, Tc>(Applicative<Tb> $next): Applicative<Tc> {
        return $next->cata(
            (Add $y) ==> {
                $f = $this->_x; /* @var callable $f */
                return new Done($f($y));
            },
            (Add $y) ==> {
                $f = $this->_x; /* @var callable $f */
                return new More($f($y));
            }
        );
    }

    public function map<Tb>((function(T): Tb) $f): Finishable<Tb> {
        return new More($f($this->_x));
    }

    public function flatMap<Tb>((function(T): Finishable<Tb>) $f): Finishable<Tb> {
        $result = $f($this->_x);
    }

    public function zero(): this {
        return new More($this->_x->zero());
    }

    public function equals(Eq $other): bool {
        return $other->cata(
            ()       ==> false,
            (Add $y) ==> $this->_x->equals($y)
        );
    }

    public function getEnumKey(): int {
        return Finishable::MORE;
    }

    public function compare(Ord $other): int {
        return $other->cata(
            ()       ==> Ord::LESS,
            (Add $y) ==> $this->_x->compare($y)
        );
    }

    public function show(): string {
        return "More({$this->_x->show()})";
    }

    public function unbox(): T {
        return $this->_x;
    }

    public function cata<Tb>((function(T): Tb) $done, (function(T): Tb) $more): \Tb {
        return $more($this->_x);
    }

}