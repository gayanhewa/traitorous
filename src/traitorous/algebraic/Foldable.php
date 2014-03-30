<?hh // strict
namespace traitorous\algebraic;

interface Foldable<A> {

    public function foldMap<M as Monoid>(M $zero, (function(A): M) $f): M;

    public function foldr<B>((function(A, B): B) $f, B $init): B;

    public function foldl<B>((function(B, A): B) $f, B $init): B;
			
}