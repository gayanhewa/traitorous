<?hh // strict
namespace traitorous\form\validators;

use traitorous\form\FormErrors;
use traitorous\form\KeyedFormValidator;
use traitorous\form\errors\KeyedFormError;
use traitorous\Option;
use traitorous\Validation;
use traitorous\validation\Failure;
use traitorous\validation\Success;

final class NonEmptyFormValidator implements KeyedFormValidator {

    public function __construct(
        private int $_min,
        private string $_errorMessage
    ) { }

    public function validate(
        string $key,
        Option<string> $optionalValue
    ): Validation<FormErrors, bool> {
        return $optionalValue->cata(
            () ==> new Failure(new FormErrors(Vector {
                new KeyedFormError($key, $this->_errorMessage)
            })),
            ($x) ==> new Success(true)
        );
    }

}