<?hh // strict
namespace traitorous\outlaw;

interface LeftMappable<T> {

    public function leftMap<A>((function(T): A) $f): LeftMappable<A>;

}
