<?hh // strict
namespace traitorous\outlaw;

interface Containable<A> {

    public function contains(A $a): bool;

}