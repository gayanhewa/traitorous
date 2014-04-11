<?hh // strict
namespace traitorous\outlaw;

interface Eq<Tself> {

    public function equals(Tself $other): bool;

}