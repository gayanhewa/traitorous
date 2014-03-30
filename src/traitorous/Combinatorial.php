<?hh // strict
namespace traitorous;

final class Combinatorial {

    public static function apply<A, B>(): (function((function(A): B), B): B) {
        return ((function(A): B) $f, B $x) ==> $f($x);
    }

    public static function compose<A, B, C>(): (function((function(B): C), (function(A): B), A): C) {
        return ((function(B): C) $f, (function(A): B) $g, A $x) ==> $f($g($x));
    }

    public static function compose1<A, B, C>((function(B): C) $f): (function((function(A): B), A): C) {
        return ((function(A): B) $g, A $x) ==> $f($g($x));
    }

    public static function compose2<A, B, C>((function(B): C) $f, (function(A): B) $g): (function(A): C) {
        return (\A $x) ==> $f($g($x));
    }

    public static function constant<A, B>(): (function(A, B): A) {
        return (\A $a, \B $b) ==> $a;
    }

    public static function constant1<A, B>(\A $a): (function(B): A) {
        return (\B $b) ==> $a;
    }

    public static function flip<A, B, C>(): (function((function(A, B): C), A, B): C) {
        return ((function(A, B): C) $f, \A $a, \B $b) ==> $f($b, $a);
    }

    public static function flip1<A, B, C>((function(A, B): C) $f): (function(A, B): C) {
        return (\A $a, \B $b) ==> $f($b, $a);
    }

    public static function flip2<A, B, C>((function(A, B): C) $f, \A $a): (function(B): C) {
        return (\B $b) ==> $f($b, $a);
    }

    public static function identity<A>(): (function(A): A) {
        return (\A $a) ==> $a;
    }

    public static function identity1<A>(\A $a): (function(): A) {
        return () ==> $a;
    }

}