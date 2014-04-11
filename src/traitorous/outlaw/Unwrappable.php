<?hh // strict
namespace traitorous\outlaw;

interface Unwrappable<T> {

    public function getOrElse((function(): T) $f): T;

    public function getOrDefault(T $default): T;

}