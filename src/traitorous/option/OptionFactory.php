<?hh
namespace traitorous\option;

final class OptionFactory {

    public static function fromValue<T>(?\T $a): Option<\T> {
        if ($a === null) {
            return new None();
        } else {
            return new Some($a);
        }
    }

}