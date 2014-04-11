<?hh // strict
namespace traitorous;

use traitorous\algebraic\Functor;
use traitorous\algebraic\Applicative;
use traitorous\algebraic\Alternative;
use traitorous\algebraic\Monad;
use traitorous\algebraic\MonadPlus;
use traitorous\algebraic\Monoid;
use traitorous\algebraic\Foldable;
use traitorous\outlaw\Add;
use traitorous\outlaw\Conjoinable;
use traitorous\outlaw\Disjoinable;
use traitorous\outlaw\Containable;
use traitorous\outlaw\Container;
use traitorous\outlaw\Droppable;
use traitorous\outlaw\Takeable;
use traitorous\outlaw\Filterable;
use traitorous\Option;
use traitorous\option\Some;
use traitorous\option\None;

final class ImmutableVector<T> implements Functor<T>,
                                          Applicative<T>,
                                          Alternative<T>,
                                          Monad<T>,
                                          Monoid<ImmutableVector<T>>,
                                          Foldable<T>,
                                          Conjoinable<ImmutableVector<T>>,
                                          Disjoinable<ImmutableVector<T>>,
                                          Containable<T>,
                                          Container,
                                          Droppable<T, ImmutableVector<T>>,
                                          Takeable<T, ImmutableVector<T>>,
                                          Filterable<T, ImmutableVector<T>>
{

    private ImmVector<T> $_n;

    public function __construct(?Traversable<T> $it = null) {
        $this->_n = new ImmVector($it);
    }

    public function map<Tb>((function(T): Tb) $f): ImmutableVector<Tb> {
        return new ImmutableVector($this->_n->map($f));
    }

    public function ap<Tb, Tc>(Applicative<Tb> $other): ImmutableVector<Tc> {
        // UNSAFE
        return $this->flatMap(($f) ==> $this->map($f));
    }

    public function orThis(Alternative<T> $other): ImmutableVector<T> {
        invariant($other instanceof ImmutableVector, "Expecting ImmutableVector<T>");
        return $this->conj($other);
    }

    public function orElse((function(): Alternative<T>) $f): ImmutableVector<T> {
        $n = $f();
        invariant($n instanceof ImmutableVector, "Expected an ImmutableVector<T>");
        return $this->conj($n);
    }

    public function flatMap<Tb>((function(T): Monad<Tb>) $f): ImmutableVector<Tb> {
        $vector = $this->foldl(new Vector([]), ($m, $n) ==> {
            $v = $f($n);
            invariant($v instanceof ImmutableVector, "Expected an ImmutableVector<Tb>");
            return $m->addAll($v->toArray());
        });
        return new ImmutableVector($vector);
    }

    public function zero(): ImmutableVector<T> {
        return new ImmutableVector([]);
    }

    public function add(ImmutableVector<T> $other): ImmutableVector<T> {
        return $this->conj($other);
    }

    public function foldMap<Tm as Monoid>(Tm $zero, (function(T): Tm) $f): Tm {
        // UNSAFE
        return $this->foldl($zero, ($m, $n) ==> $m->add($f($n)));
    }

    public function foldr<Tb>(Tb $init, (function(T, Tb): Tb) $f): Tb {
        return array_reduce(
            array_reverse($this->_n->toArray()),
            Combinatorial::flip1($f),
            $init
        );
    }

    public function foldl<Tb>(Tb $init, (function(Tb, T): Tb) $f): Tb {
        return array_reduce($this->_n->toArray(), $f, $init);
    }

    public function conj(ImmutableVector<T> $ys): ImmutableVector<T> {
        return new ImmutableVector(array_merge($this->_n->toArray(), $ys->toArray()));
    }

    public function disj(ImmutableVector<T> $ys): ImmutableVector<T> {
        return new ImmutableVector($this->_n->filter(($x) ==> $ys->contains($x)));
    }

    public function contains(T $a): bool {
        return $this->_n->linearSearch($a) !== -1;
    }

    public function length(): int {
        return $this->_n->count();
    }

    public function isEmpty(): bool {
        return $this->_n->isEmpty();
    }

    public function nonEmpty(): bool {
        return !$this->isEmpty();
    }

    public function drop(int $n): ImmutableVector<T> {
        return new ImmutableVector(array_slice($this->_n->toArray(), $n));
    }

    public function dropWhile((function(T): bool) $f): ImmutableVector<T> {
        return $this->findOffsetOf($f)->cata(
            ()   ==> new ImmutableVector(),
            ($p) ==> $this->drop($p)
        );
        
    }

    public function filter((function(T): bool) $p): ImmutableVector<T> {
        return new ImmutableVector($this->_n->filter($p));
    }

    public function take(int $n): ImmutableVector<T> {
        return new ImmutableVector(array_slice($this->_n->toArray(), 0, $n));
    }

    public function takeWhile((function(T): bool) $p): ImmutableVector<T> {
        return $this->findOffsetOf($p)->cata(
            ()   ==> new ImmutableVector(),
            ($p) ==> $this->take($p)
        );
    }

    public function toArray(): array<int, T> {
        return $this->_n->toArray();
    }

    public function at(int $offset): Option<T> {
        try {
            return new Some($this->_n->at($offset));
        } catch (\Exception $e) {
            return new None();
        }
    }

    public function findOffset(T $n): Option<int> {
        $p = $this->_n->linearSearch($n);
        return ($p !== -1) ? new Some($p) : new None();
    }

    public function findOffsetOf((function(T): bool) $p): Option<int> {
        for ($i = 0; $i < $this->_n->count(); $i++) {
            if ($p($this->_n->at($i))) { return new Some($i); }
        }
        return new None();
    }

}