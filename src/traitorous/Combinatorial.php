<?hh // strict
namespace traitorous;

final class Combinatorial {

    public static function apply<Ta, Tb>(): (function((function(Ta): Tb), Ta): Tb) {
        return ($f, $x) ==> $f($x);
    }

    public static function compose<Ta, Tb, Tc>(): (function((function(Tb): Tc), (function(Ta): Tb), Ta): Tc) {
        return ($f, $g, $x) ==> $f($g($x));
    }

    public static function compose1<Ta, Tb, Tc>((function(Tb): Tc) $f): (function((function(Ta): Tb), Ta): Tc) {
        return ($g, $x) ==> $f($g($x));
    }

    public static function compose2<Ta, Tb, Tc>((function(Tb): Tc) $f, (function(Ta): Tb) $g): (function(Ta): Tc) {
        return ($x) ==> $f($g($x));
    }

    public static function constant<Ta, Tb>(): (function(Ta, Tb): Ta) {
        return ($a, $b) ==> $a;
    }

    public static function constant1<Ta, Tb>(Ta $a): (function(Tb): Ta) {
        return ($b) ==> $a;
    }

    public static function flip<Ta, Tb, Tc>(): (function((function(Tb, Ta): Tc), Ta, Tb): Tc) {
        return ($f, $a, $b) ==> $f($b, $a);
    }

    public static function flip1<Ta, Tb, Tc>((function(Tb, Ta): Tc) $f): (function(Ta, Tb): Tc) {
        return ($a, $b) ==> $f($b, $a);
    }

    public static function flip2<Ta, Tb, Tc>((function(Tb, Ta): Tc) $f, Ta $a): (function(Tb): Tc) {
        return ($b) ==> $f($b, $a);
    }

    public static function identity<Ta>(): (function(Ta): Ta) {
        return ($a) ==> $a;
    }

    public static function identity1<Ta>(Ta $a): (function(): Ta) {
        return () ==> $a;
    }

}