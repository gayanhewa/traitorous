<?hh // strict
namespace traitorous\outlaw;

interface Ord<Tself> {

    const LESS    = 0;
    const EQUAL   = 1;
    const GREATER = 2;

    public function compare(Tself $other): int;

}