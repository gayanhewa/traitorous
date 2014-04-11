<?hh // strict
namespace traitorous\form\validators;

use traitorous\form\FormErrors;
use traitorous\form\errors\KeyedFormError;
use traitorous\form\KeyedFormValidator;
use traitorous\matcher\StringMatcher;
use traitorous\Option;
use traitorous\Validation;
use traitorous\validation\Failure;
use traitorous\validation\Success;

final class StringMatchFormValidator implements KeyedFormValidator {

    public function __construct(
        private StringMatcher $_matcher,
        private string $_errorMessage
    ) { }

    public function validate(
        string $key,
        Option<string> $optionalValue
    ): Validation<FormErrors, bool>
    {
        return $optionalValue->cata(
            () ==> {
                return new Failure(new FormErrors(Vector {
                    new KeyedFormError($key, $this->_errorMessage)
                }));
            },
            ($value) ==> {
                if ($this->_matcher->match($value)) {
                    return new Success(true);
                } else {
                    return new Failure(new FormErrors(Vector {
                        new KeyedFormError($key, $this->_errorMessage)
                    }));
                }
            }
        );
    }

}