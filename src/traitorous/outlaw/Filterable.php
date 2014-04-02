<?hh // strict
namespace traitorous\outlaw;

interface Filterable<T> {

    public function filter((function(T): bool) $p): Filterable<T>;

}