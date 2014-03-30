<?hh // strict
namespace traitorous\finishable;

use traitorous\algebraic\Applicative;
use traitorous\algebraic\MonadOps;
use traitorous\Finishable;
use traitorous\outlaw\Add;
use traitorous\outlaw\Eq;
use traitorous\outlaw\Ord;

final class Done<A> implements Finishable<A> {

    public function __construct(private $_x) { }

    public function add(Add $other): this {
        return $other->cata(
            (Add $y) ==> new Done($this->_x->add($y)),
            (Add $y) ==> new Done($this->_x->add($y))
        );
    }

    public function ap<B, C>(Applicative<B> $next): Finishable<C> {
        return $this;
    }

    public function map<B>((function(A): B) $f): Finishable<B> {
        return $this;
    }

    public function flatMap<B>((function(A): Finishable<B>) $f): Finishable<B> {
        return $this;
    }

    public function zero(): this {
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

    public function cata<B>((function(A): B) $done, (function(A): B) $more): B {
        return $done($this->_x);
    }

}