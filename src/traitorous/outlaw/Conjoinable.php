<?hh // strict
namespace traitorous\outlaw;

interface Conjoinable<Tself> {

	public function conj(Tself $xs): Tself;

}