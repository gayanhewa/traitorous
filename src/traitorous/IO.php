<?hh // strict
namespace traitorous;

use traitorous\algebraic\Applicative;
use traitorous\algebraic\Functor;
use traitorous\algebraic\Monad;
use traitorous\algebraic\MonadOps;

final class IO<T> implements Functor<T>, Applicative<T>, Monad<T> {

    public function __construct(private (function(): T) $_f) { }

    public static function of($x): IO<T> {
        return new IO(() ==> $x);
    }

    public function map<Tb>((function(T): Tb) $f): IO<Tb> {
        return $this->flatMap((T $a) ==> IO::of($f($a)));
    }

    public function ap<Tb, Tc>(Applicative<Tb> $next): Applicative<Tc> {
        return $this->flatMap(((function(Tb): Tc) $f) ==> $next->map($f));
    }

    public function flatMap<Tb>((function(T): IO<Tb>) $f): IO<Tb> {
        return new IO(() ==> $f($this->unsafePerform())->unsafePerform());
    }

    public function unsafePerform(): A {
        $redeemer = $this->_f;
        return $redeemer();
    }

}