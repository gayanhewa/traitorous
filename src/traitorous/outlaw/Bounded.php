<?hh // strict
namespace traitorous\outlaw;

interface Bounded {

    public function minValue(): this;

    public function maxValue(): this;

}