<?hh // strict
namespace traitorous;

use traitorous\outlaw\Eq;
use traitorous\outlaw\KeyedEnum;
use traitorous\outlaw\Ord;
use traitorous\outlaw\Show;

interface Finishable<Tm, Td> extends Show,
                                     Eq<Finishable<Tm, Td>>,
                                     Ord<Finishable<Tm, Td>>,
                                     KeyedEnum
{
    const DONE = 0;
    const MORE = 1;

    public function cata<Tb>((function(Td): Tb) $done, (function(Tm): Tb) $more): Tb;
}