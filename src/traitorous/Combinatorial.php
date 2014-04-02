<?hh // strict
namespace traitorous;

final class Combinatorial {

    public static function apply<Ta, Tb>(): (function((function(Ta): Tb), Tb): Tb) {
        return ((function(Ta): Tb) $f, Tb $x) ==> $f($x);
    }

    public static function compose<Ta, Tb, Tc>(): (function((function(Tb): Tc), (function(Ta): Tb), Ta): Tc) {
        return ((function(Tb): Tc) $f, (function(Ta): Tb) $g, Ta $x) ==> $f($g($x));
    }

    public static function compose1<Ta, Tb, Tc>((function(Tb): Tc) $f): (function((function(Ta): Tb), Ta): Tc) {
        return ((function(Ta): Tb) $g, Ta $x) ==> $f($g($x));
    }

    public static function compose2<Ta, Tb, Tc>((function(Tb): Tc) $f, (function(Ta): Tb) $g): (function(Ta): Tc) {
        return (\Ta $x) ==> $f($g($x));
    }

    public static function constant<Ta, Tb>(): (function(Ta, Tb): Ta) {
        return (\Ta $a, \Tb $b) ==> $a;
    }

    public static function constant1<Ta, Tb>(\Ta $a): (function(Tb): Ta) {
        return (\Tb $b) ==> $a;
    }

    public static function flip<Ta, Tb, Tc>(): (function((function(Ta, Tb): Tc), Ta, Tb): Tc) {
        return ((function(Ta, Tb): Tc) $f, \Ta $a, \Tb $b) ==> $f($b, $a);
    }

    public static function flip1<Ta, Tb, Tc>((function(Ta, Tb): Tc) $f): (function(Ta, Tb): Tc) {
        return (\Ta $a, \Tb $b) ==> $f($b, $a);
    }

    public static function flip2<Ta, Tb, Tc>((function(Ta, Tb): Tc) $f, \Ta $a): (function(Tb): Tc) {
        return (\Tb $b) ==> $f($b, $a);
    }

    public static function identity<Ta>(): (function(Ta): Ta) {
        return (\Ta $a) ==> $a;
    }

    public static function identity1<Ta>(\Ta $a): (function(): Ta) {
        return () ==> $a;
    }

}