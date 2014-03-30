<?hh // strict
namespace traitorous\form\validators;

use traitorous\form\errors\KeyedFormError;
use traitorous\form\FormErrors;
use traitorous\form\KeyedFormValidator;
use traitorous\Option;
use traitorous\Validation;
use traitorous\validation\Failure;
use traitorous\validation\Success;

final class MinLengthFormValidator implements KeyedFormValidator {

    public function __construct(
        private int $_length,
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
            (string $value) ==> {
                if (strlen(($value)) >= $this->_length) {
                    return new Success($value);
                } else {
                    return new Failure(new FormErrors(Vector {
                        new KeyedFormError($key, $this->_errorMessage)
                    }));
                }
            }
        );
    }

}