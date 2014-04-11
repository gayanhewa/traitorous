<?hh // strict
namespace traitorous\algebraic;

use traitorous\outlaw\Zero;

interface Monoid<Tself> extends SemiGroup<Tself>, Zero<Tself> {
}