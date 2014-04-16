<?hh // strict
namespace traitorous\outlaw;

interface Invertable<Tinvert> {

    public function invert(): Tinvert;

}