<?hh // strict
namespace traitorous\outlaw;

interface Subtract<Tself> {

    public function subtract(Tself $other): Tself;

}