<?hh // strict
namespace traitorous\outlaw;

interface Unboxable<T> {

    public function unbox(): T;

}