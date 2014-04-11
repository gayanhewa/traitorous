<?hh // strict
namespace traitorous\algebraic;

use traitorous\outlaw\Zero;

interface Alternative<T> extends Applicative<T> {

    public function orThis(Alternative<T> $other): Alternative<T>;

    public function orElse((function(): Alternative<T>) $f): Alternative<T>;

}