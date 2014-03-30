<?hh // strict
namespace traitorous\finishable;

use traitorous\algebraic\Applicative;
use traitorous\algebraic\MonadOps;
use traitorous\Finishable;
use traitorous\outlaw\Add;
use traitorous\outlaw\Eq;
use traitorous\outlaw\Ord;

final class More<A> implements Finishable<A> {

    public function __construct(private $_x): void { }

    public function add(Add $other): this {
        return $other->cata(
            function(Add $y) { return new Done($this->_x->add($y)); },
            function(Add $y) { return new More($this->_x->add($y)); }
        );
    }

    public function ap<B, C>(Applicative<B> $next): Applicative<C> {
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

    public function map<B>((function(A): B) $f): Finishable<B> {
        return new More($f($this->_x));
    }

    public function flatMap<B>((function(A): Finishable<B>) $f): Finishable<B> {
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

    public function unbox(): A {
        return $this->_x;
    }

    public function cata<B>((function(A): B) $done, (function(A): B) $more): B {
        return $more($this->_x);
    }

}