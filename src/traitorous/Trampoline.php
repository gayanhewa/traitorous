<?hh
namespace traitorous;

final class Trampoline {

    public static function bounce<T>(Finishable<(function(): Finishable), T> $thunk): T {
        while($thunk->getEnumKey() === Finishable::MORE) {
            $thunk = $thunk->cata(
                ($n) ==> new Done($n),
                ($f) ==> $f()
            );
        }
        return $thunk->cata(
            ($n) ==> $n,
            ($_) ==> new \Exception("Invalid state.")
        );
    }

}