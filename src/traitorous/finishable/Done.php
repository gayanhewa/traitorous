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

final class Done<Tm, Td> implements Finishable<Tm, Td> {

    public function __construct(private Td $_x) { }

    public function equals(Finishable<Tm, Td> $other): bool {
        invariant($this->_x instanceof Eq, "Expected Done to contain an Eq");
        return $other->cata(
            ($y) ==> $this->_x->equals($y),
            ($y) ==> false
        );
    }

    public function getEnumKey(): int {
        return Finishable::DONE;
    }

    public function compare(Finishable<Tm, Td> $other): int {
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

    public function cata<Tb>((function(Td): Tb) $done, (function(Tm): Tb) $more): Tb {
        return $done($this->_x);
    }

}