<?hh // strict
namespace traitorous\outlaw;

use traitorous\Option;

interface Intersectable<Tself> {

    public function intersection(Tself $other): Tself;

}