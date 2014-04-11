<?hh // strict
namespace traitorous\outlaw;

interface Disjoinable<Tself> {

    public function disj(Tself $xs): Tself;

}