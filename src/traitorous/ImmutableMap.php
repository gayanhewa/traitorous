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

final class ImmutableMap<Tk, Tv> implements Monoid,
                                            Conjoinable,
                                            Disjoinable,
                                            Containable<Tk>,
                                            Container,
                                            Intersectable,
                                            ISet<Tk, Tv>
{

    private ImmMap<Tk, Tv> $_n;

    public function __construct(?Traversable<Tv> $it = null) {
        $this->_n = new ImmVector($it);
    }

    public function zero(): ImmutableMap<Tk, Tv> {
        return new ImmutableMap();
    }

    public function add(Add $other): ImmutableMap<Tk, Tv> {
        invariant($other instanceof ImmutableMap<Tk, Tv>, "Expected ImmutableMap<Tk, Tv>");
        return $this->conj($other);
    }

    public function conj(Conjoinable $ys): ImmutableMap<Tk, Tv> {
        invariant($other instanceof ImmutableMap<Tk, Tv>, "Expected ImmutableMap<Tk, Tv>");
        return new ImmutableMap(array_merge($this->toArray(), $ys->toArray()));
    }

    public function disj(Disjoinable $ys): ImmutableMap<Tk, Tv> {
        invariant($other instanceof ImmutableMap<Tk, Tv>, "Expected ImmutableMap<Tk, Tv>");
        return new ImmutableMap(array_diff_key($this->toArray(), $ys->toArray()));
    }

    public function intersection(Intersectable $other): ImmutableMap<Tk, Tv> {
        invariant($other instanceof ImmutableMap<Tk, Tv>, "Expected ImmutableMap<Tk, Tv>");
        return new ImmutableMap(array_intersect_key($this->toArray(), $ys->toArray()));
    }

    public function contains(\Tk $a): bool {
        return $this->_n->containsKey($a);
    }

    public function get(\Tk $key): Option<Tv> {
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

    public function keys(): Vector<Tk> {
        return $this->_n->keys();
    }

    public function values(): Vector<Tv> {
        return $this->_n->values();
    }

    public function toArray(): array {
        return $this->_n->toArray();
    }

}