<?hh // strict
namespace traitorous\option;

use traitorous\algebraic\Alternative;
use traitorous\algebraic\Applicative;
use traitorous\algebraic\MonadOps;
use traitorous\algebraic\MonadPlus;
use traitorous\Option;
use traitorous\outlaw\Add;
use traitorous\outlaw\Eq;
use traitorous\outlaw\Ord;

final class Some<A> implements Option<A> {

    public function __construct(private $_inner): void { }

    public function getEnumKey(): int {
        return Option::SOME;
    }

    public function add(Add $other): this {
        return $other->cata(
            (  ) ==> $this,
            ($n) ==> new Some($this->_inner->add($n))
        );
    }

    public function zero(): this {
        return new None();
    }

    public function map<B>((function(A): B) $f): Option<B> {
        return new Some($f($this->_inner));
    }

    public function ap<B, C>(Applicative<B> $other): Option<C> {
        return $other->map($this->_inner);
    }

    public function orThis(Alternative<A> $other): Option<A> {
        return $this;
    }

    public function orElse((function(): Alternative<A>) $other): Option<A> {
        return $this;
    }

    public function flatMap<B>((function(A): Option<B>) $f): Option<B> {
        return $f($this->_inner);
    }

    public function mplus(MonadPlus $other): this {
        return $this;
    }

    public function show(): string {
        /**
         * @var \traitorous\outlaw\Show $showable
         */
        $showable = $this->_inner;
        return "Show({$showable->show()})";
    }

    public function length(): int {
        return 1;
    }

    public function isEmpty(): bool {
        return false;
    }

    public function nonEmpty(): bool {
        return true;
    }

    public function getOrElse((function(): A) $f): A {
        return $this->_inner;
    }

    public function getOrDefault(\A $default): A {
        return $this->_inner;
    }

    public function filter((function(A): bool) $predicate): this {
        if ($predicate($this->_inner)) {
            return $this;
        } else {
            return new None();
        }
    }

    public function equals(Eq $other): bool {
        return $other->cata(
            (  ) ==> false,
            ($n) ==> $this->_inner->equals($n)
        );
    }

    public function compare(Ord $other): int {
        return $other->cata(
            (  ) ==> Ord::GREATER,
            ($n) ==> $this->_inner->compare($n)
        );
    }

    public function cata<B>((function(): B) $none, (function(A): B) $some) {
        return $some($this->_inner);
    }
}