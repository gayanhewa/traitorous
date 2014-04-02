<?hh // strict
namespace traitorous\outlaw;

interface LeftMappable<T> {

    public function leftMap<Tb>((function(T): Tb) $f): LeftMappable<Tb>;

}
