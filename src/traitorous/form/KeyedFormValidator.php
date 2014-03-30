<?hh // strict
namespace traitorous\form;

use traitorous\Option;
use traitorous\Validation;

interface KeyedFormValidator {

    public function validate(
        string $key,
        Option<string> $optionalValue
    ): Validation<FormErrors, bool>;

}