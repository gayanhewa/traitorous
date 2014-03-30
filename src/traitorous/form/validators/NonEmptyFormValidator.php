<?hh // strict
namespace traitorous\form\validators;

use traitorous\form\FormErrors;
use traitorous\form\KeyedFormValidator;
use traitorous\form\errors\KeyedFormError;
use traitorous\Option;
use traitorous\Validation;

final class NonEmptyFormValidator implements KeyedFormValidator {

    public function __construct(
        private int $_min,
        private string $errorMessage
    ) { }

    public function validate(
        string $key,
        Option<string> $optionalValue
    ): Validation<FormErrors, bool>
    {
        return $this->_min->validate($key, $optionalValue);
    }

}