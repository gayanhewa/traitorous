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

final class More<Tm, Td> implements Finishable<Tm, Td> {

    public function __construct(private Tm $_x): void { }

    public function equals(Finishable<Tm, Td> $other): bool {
        if ($this->_x instanceof Eq) {
            return $other->cata(
                ($y) ==> false,
                ($y) ==> $this->_x->equals($y)
            );
        } else {
            return $other->cata(
                ($y) ==> false,
                ($y) ==> $this->_x === $y
            );
        }
    }

    public function getEnumKey(): int {
        return Finishable::MORE;
    }

    public function compare(Finishable<Tm, Td> $other): int {
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

    public function cata<Tb>((function(Td): Tb) $done, (function(Tm): Tb) $more): Tb {
        return $more($this->_x);
    }

}