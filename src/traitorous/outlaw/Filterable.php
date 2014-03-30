<?hh // strict
namespace traitorous\outlaw;

interface Filterable<A> {

    public function filter((function(A): bool) $p): this;

}