<?hh // strict
namespace traitorous\option;

use traitorous\Option;
use traitorous\option\Some;
use traitorous\option\None;

final class OptionFactory {

    public static function fromValue<T>(?T $a): Option<T> {
        if ($a === null) {
            return new None();
        } else {
            return new Some($a);
        }
    }

}