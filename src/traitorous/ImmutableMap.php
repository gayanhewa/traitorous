<?hh // strict
namespace traitorous;

final class ImmutableMap<Tk, Tv> implements Monoid {

    private ImmMap<Tk, Tv> $_n;

    public function __construct(?Traversable<Tv> $it) {
        $this->_n = new ImmVector($it);
    }

    public function zero(): ImmutableMap<Tk, Tv> {
        return new ImmutableMap();
    }

    public function add(ImmutableMap<Tk, Tv> $other): ImmutableMap<Tk, Tv> {
        return $this->conj($other);
    }

    public function conj(ImmutableMap<Tk, Tv> $xs): ImmutableMap<Tk, Tv> {
    }

}