<?hh // strict
namespace traitorous\outlaw;

use traitorous\Option;

interface Set<T> {

	public function intersection<T> (Set<T> $xs): this;

	public function get(\T $a): Option<T>;

}