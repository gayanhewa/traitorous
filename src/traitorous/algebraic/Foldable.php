<?hh // strict
namespace traitorous\algebraic;

interface Foldable<T> {

    public function foldMap<Tm as Monoid>(Tm $zero, (function(T): Tm) $f): Tm;

    public function foldr<Tb>((function(T, Tb): Tb) $f, Tb $init): Tb;

    public function foldl<Tb>((function(Tb, T): Tb) $f, Tb $init): Tb;
			
}