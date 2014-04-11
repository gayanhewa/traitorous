<?hh // strict
namespace traitorous\outlaw;

interface Filterable<T, Tself> {

    public function filter((function(T): bool) $p): Tself;

}