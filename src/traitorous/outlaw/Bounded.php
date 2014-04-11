<?hh // strict
namespace traitorous\outlaw;

interface Bounded<Tself> {

    public function minValue(): Tself;

    public function maxValue(): Tself;

}