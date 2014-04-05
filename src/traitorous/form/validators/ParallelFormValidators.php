<?hh // strict
namespace traitorous\form\validators;

use traitorous\form\FormValidator;
use traitorous\form\FormError;
use traitorous\form\FormErrors;
use traitorous\form\errors\KeyedFormError;
use traitorous\http\HttpRequest;
use traitorous\ImmutableMap;
use traitorous\validation\Success;
use traitorous\validation\Failure;
use traitorous\Validation;

final class ParallelFormValidators implements FormValidator {

    public function __construct(private Vector<FormValidator> $_manifest) { }

    public function validate(
        ImmutableMap<string, string> $data
    ): Validation<FormErrors, bool> {
        return array_reduce(
            $this->_manifest->toArray(),
            (Validation $status, FormValidator $validator) ==> {
                return $validator->validate($data)->cata(
                    (FormErrors $error) ==> $status->cata(
                        (FormErrors $errors) ==> new Failure($errors->add($error)),
                        ($_)                 ==> new Failure($error)
                    ),
                    ($_) ==> $status->cata(
                        (FormErrors $errors) ==> new Failure($errors),
                        ($s)                 ==> new Success($s)
                    )
                );
            },
            new Success(true)
        );
    }

}