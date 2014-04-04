<?hh // strict
namespace traitorous\outlaw;

use traitorous\Option;

interface Intersectable {

    public function intersection(Intersectable $other): Intersectable;

}