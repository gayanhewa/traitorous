<?hh // strict
namespace traitorous\outlaw;

interface Conjoinable {

	public function conj(Conjoinable $xs): Conjoinable;

}