<?hh // strict
namespace traitorous;

use traitorous\outlaw\Add;
use traitorous\outlaw\Conjoinable;

final class Revolver {

    public static function add<T as Add>(): (function(T, T): T) {
        return ($a, $b) ==> $a->add($b);
    }

    public static function add1<T as Add>(Add<T> $a): (function(T): T) {
        return ($b) ==> $a->add($b);
    }

    public static function conj<T as Conjoinable>(): (function(T, T): T) {
        return ($a, $b) ==> $a->conj($b);
    }

    public static function conj1<T as Conjoinable>(T $a): (function(T): T) {
        return ($b) ==> $a->conj($b);
    }

}