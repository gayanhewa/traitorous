<?hh // strict
namespace traitorous\form\validators;

use traitorous\form\KeyedFormValidator;
use traitorous\form\FormErrors;
use traitorous\matcher\string\StringRegexMatcher;
use traitorous\Option;
use traitorous\Validation;

final class EmailFormValidator implements KeyedFormValidator {

    private StringMatchFormValidator $_email;

    public function __construct(string $errorMessage) {
        $this->_email = new StringMatchFormValidator(
            new StringRegexMatcher("/\\S+@\\S+\\.\\S+/"),
            $errorMessage
        );
    }

    public function validate(
        string $key,
        Option<string> $optionalValue
    ): Validation<FormErrors, bool>
    {
        return $this->_email->validate($key, $optionalValue);
    }

}