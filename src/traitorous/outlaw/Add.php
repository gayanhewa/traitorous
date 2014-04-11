<?hh // strict
namespace traitorous\outlaw;

interface Add<Tself> {

    public function add(Tself $other): Tself;

}