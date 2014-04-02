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

final class Some<T> implements Option<T> {

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

    public function map<Tb>((function(T): Tb) $f): Option<Tb> {
        return new Some($f($this->_inner));
    }

    public function ap<Tb, Tc>(Applicative<Tb> $other): Option<Tc> {
        return $other->map($this->_inner);
    }

    public function orThis(Alternative<T> $other): Option<T> {
        return $this;
    }

    public function orElse((function(): Alternative<T>) $other): Option<T> {
        return $this;
    }

    public function flatMap<Tb>((function(T): Option<Tb>) $f): Option<Tb> {
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

    public function getOrElse((function(): T) $f): \T {
        return $this->_inner;
    }

    public function getOrDefault(\T $default): \T {
        return $this->_inner;
    }

    public function filter((function(T): bool) $predicate): Option<T> {
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

    public function cata<Tb>((function(): Tb) $none, (function(T): Tb) $some): \Tb {
        return $some($this->_inner);
    }
}