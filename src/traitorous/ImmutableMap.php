<?hh // strict
namespace traitorous;

use traitorous\algebraic\Monoid;
use traitorous\outlaw\Add;
use traitorous\outlaw\Conjoinable;
use traitorous\outlaw\Disjoinable;
use traitorous\outlaw\Containable;
use traitorous\outlaw\Container;
use traitorous\outlaw\Intersectable;
use traitorous\outlaw\ISet;
use traitorous\Option;
use traitorous\option\OptionFactory;

final class ImmutableMap<Tk, Tv> implements Monoid<ImmutableMap<Tk, Tv>>,
                                            Conjoinable<ImmutableMap<Tk, Tv>>,
                                            Disjoinable<ImmutableMap<Tk, Tv>>,
                                            Containable<Tk>,
                                            Container,
                                            Intersectable<ImmutableMap<Tk, Tv>>,
                                            ISet<Tk, Tv>
{

    private ImmMap<Tk, Tv> $_n;

    public function __construct(?KeyedTraversable<Tk, Tv> $it = null) {
        $this->_n = new ImmMap($it);
    }

    public function zero(): ImmutableMap<Tk, Tv> {
        return new ImmutableMap();
    }

    public function add(ImmutableMap<Tk, Tv> $other): ImmutableMap<Tk, Tv> {
        return new ImmutableMap(array_merge($this->toArray(), $other->toArray()));
    }

    public function conj(ImmutableMap<Tk, Tv> $ys): ImmutableMap<Tk, Tv> {
        return new ImmutableMap(array_merge($this->toArray(), $ys->toArray()));
    }

    public function disj(ImmutableMap<Tk, Tv> $ys): ImmutableMap<Tk, Tv> {
        return new ImmutableMap(array_diff_key($this->toArray(), $ys->toArray()));
    }

    public function intersection(ImmutableMap<Tk, Tv> $other): ImmutableMap<Tk, Tv> {
        return new ImmutableMap(array_intersect_key($this->toArray(), $other->toArray()));
    }

    public function contains(Tk $a): bool {
        return $this->_n->containsKey($a);
    }

    public function get(Tk $key): Option<Tv> {
        return OptionFactory::fromValue($this->_n->get($key));
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

    public function keys(): ImmVector<Tk> {
        return $this->_n->keys()->immutable();
    }

    public function values(): ImmVector<Tv> {
        return $this->_n->values()->immutable();
    }

    public function toArray(): array<Tk, Tv> {
        return $this->_n->toArray();
    }

}