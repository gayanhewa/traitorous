<?hh // strict
namespace traitorous\algebraic;

use traitorous\outlaw\Zero;

interface Alternative<A> extends Zero, Applicative<A> {

    public function orThis(Alternative<A> $other): Alternative<A>;

    public function orElse((function(): Alternative<A>) $f): Alternative<A>;

}