<?hh // strict
namespace traitorous\outlaw;

interface Disjoinable {

    public function disj(Disjoinable $xs): this;

}