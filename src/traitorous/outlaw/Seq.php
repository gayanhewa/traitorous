<?hh // strict
namespace traitorous\outlaw;

interface Seq<T, Tself> {

    public function head(): T;

    public function tail(): Tself;

}