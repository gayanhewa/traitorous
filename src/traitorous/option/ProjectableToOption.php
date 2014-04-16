<?hh // strict
namespace traitorous\option;

use traitorous\Option;

interface ProjectableToOption<Tv> {

    public function toOption(): Option<Tv>;

}
