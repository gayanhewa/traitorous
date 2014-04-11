<?hh // strict
namespace traitorous\form\validators;

use traitorous\form\FormErrors;
use traitorous\form\errors\KeyedFormError;
use traitorous\form\KeyedFormValidator;
use traitorous\Option;
use traitorous\Validation;
use traitorous\validation\Failure;
use traitorous\validation\Success;

final class RequiredFormValidator implements KeyedFormValidator {

    public function __construct(private string $_errorMessage) { }

    public function validate(
        string $key,
        Option<string> $optionalValue
    ): Validation<FormErrors, bool>
    {
        return $optionalValue->cata(
            () ==> new Failure(new FormErrors(Vector {
                new KeyedFormError($key, $this->_errorMessage)
            })),
            ($value) ==> new Success(true)
        );
    }

}