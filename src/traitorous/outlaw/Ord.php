<?hh // strict
namespace traitorous\outlaw;

interface Ord {

    const LESS    = 0;
    const EQUAL   = 1;
    const GREATER = 2;

    public function compare(Ord $other): int;

}