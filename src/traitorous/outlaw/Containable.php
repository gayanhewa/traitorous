<?hh // strict
namespace traitorous\outlaw;

interface Containable<T> {

    public function contains(T $a): bool;

}