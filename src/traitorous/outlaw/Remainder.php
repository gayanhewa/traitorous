<?hh // strict
namespace traitorous\outlaw;

interface Remainder<Tself> {

    public function remainder(Tself $rhs): Tself;

}