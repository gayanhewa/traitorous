<?hh // strict
namespace traitorous;

use traitorous\outlaw\Add;
use traitorous\outlaw\Conjoinable;

final class Revolver {

    public static function add(): (function(Add, Add): Add) {
        return (Add $a, Add $b) ==> $a->add($b);
    }

    public static function add1(Add $a): (function(Add): Add) {
        return (Add $b) ==> $a->add($b);
    }

    public static function conj(): (function(Conjoinable, Conjoinable): Conjoinable) {
        return (Conjoinable $a, Conjoinable $b) ==> $a->conj($b);
    }

    public static function conj1(Conjoinable $a): (function(Conjoinable): Conjoinable) {
        return (Conjoinable $b) ==> $a->conj($b);
    }

}