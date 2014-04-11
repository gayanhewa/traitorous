<?hh // strict
namespace traitorous\algebraic;

interface Foldable<T> {

    public function foldMap<Tm as Monoid>(Tm $zero, (function(T): Tm) $f): Tm;

    public function foldr<Tb>(Tb $init, (function(T, Tb): Tb) $f): Tb;

    public function foldl<Tb>(Tb $init, (function(Tb, T): Tb) $f): Tb;
			
}