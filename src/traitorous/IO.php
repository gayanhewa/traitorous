<?hh // strict
namespace traitorous;

use traitorous\algebraic\Applicative;
use traitorous\algebraic\Functor;
use traitorous\algebraic\Monad;
use traitorous\algebraic\MonadOps;

final class IO<T> implements Functor<T>, Applicative<T>, Monad<T> {

    public function __construct(private (function(): T) $_f) { }

    public static function of<Tv>(Tv $x): IO<Tv> {
        return new IO(() ==> $x);
    }

    public function map<Tb>((function(T): Tb) $f): IO<Tb> {
        return $this->flatMap(($a) ==> IO::of($f($a)));
    }

    public function ap<Tb, Tc>(Applicative<Tb> $next): IO<Tc> {
        // UNSAFE HHVM doesn't track the type information for functions so i
        //        cant assert on variance to make this 100% typesafe
        return $this->flatMap(($f) ==> $next->map($f));
    }

    public function flatMap<Tb>((function(T): Monad<Tb>) $f): IO<Tb> {
        return new IO(() ==> {
            $m = $f($this->unsafePerform());
            invariant($m instanceof IO, "flatMap() must return an IO<T>");
            return $m->unsafePerform();
        });
    }

    public function unsafePerform(): T {
        $redeemer = $this->_f;
        return $redeemer();
    }

}