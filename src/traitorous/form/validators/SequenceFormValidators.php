<?hh // strict
namespace traitorous\form\validators;

use traitorous\form\FormErrors;
use traitorous\form\errors\KeyedFormError;
use traitorous\form\FormValidator;
use traitorous\http\HttpRequest;
use traitorous\ImmutableMap;
use traitorous\Validation;
use traitorous\validation\Success;

final class SequenceFormValidators implements FormValidator {

    public function __construct(private Vector<FormValidator> $_manifest) { }

    public function validate(
        ImmutableMap<string, string> $data
    ): Validation<FormErrors, bool> {
        return array_reduce(
            $this->_manifest->toArray(),
            (Validation<FormErrors, bool> $status, FormValidator $validator) ==> {
                return $status->flatMap(($_) ==> $validator->validate($data));
            },
            new Success(true)
        );
    }

}