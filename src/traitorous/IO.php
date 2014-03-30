<?hh // strict
namespace traitorous;

use traitorous\algebraic\Applicative;
use traitorous\algebraic\Functor;
use traitorous\algebraic\Monad;
use traitorous\algebraic\MonadOps;

final class IO<A> implements Functor<A>, Applicative<A>, Monad<A> {

    public function __construct(private (function(): A) $_f) { }

    public static function of($x): IO<A> {
        return new IO(() ==> $x);
    }

    public function map<B>((function(A): B) $f): IO<B> {
        return $this->flatMap(function($a) use($f) {
            return IO::of($f($a));
        });
    }

    public function ap<B, C>(Applicative<B> $next): Applicative<C> {
        return $this->flatMap(function((function(B): C) $f) use($next) {
            return $next->map($f);
        });
    }

    public function flatMap<B>((function(A): IO<B>) $f): IO<B> {
        return new IO(function() use($f) {
            return $f($this->unsafePerform())->unsafePerform();
        });
    }

    public function unsafePerform(): A {
        $redeemer = $this->_f;
        return $redeemer();
    }

}