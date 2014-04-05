<?hh // strict
namespace traitorous\http;

use traitorous\ImmutableMap;

final class Cookie {

    public static function parse(string $str): ImmutableMap<string, string> {
        $pairs = explode("; ", $str);
        $keys  = array_map(($n) ==> explode("=", $n), $pairs);
        $array = array_reduce(
            $keys,
            ($m, $n) ==> {
                $m[$n[0]] = $n[1];
                return $m;
            },
            []
        );
        return new ImmutableMap($array);
    }

}