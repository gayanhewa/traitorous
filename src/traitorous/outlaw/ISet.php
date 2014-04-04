<?hh // strict
namespace traitorous\outlaw;

use traitorous\Option;

interface ISet<Tk, Tv> {

    public function get(\Tk $a): Option<Tv>;

}