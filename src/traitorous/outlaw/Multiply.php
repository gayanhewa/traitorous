<?hh // strict
namespace traitorous\outlaw;

interface Multiply<Tself> {

    public function multiply(Tself $other): Tself;

}