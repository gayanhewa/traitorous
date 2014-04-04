<?hh // strict
namespace traitorous\outlaw;

interface Seq<T> {

    public function head(): \T;

    public function tail(): Seq<T>;

}