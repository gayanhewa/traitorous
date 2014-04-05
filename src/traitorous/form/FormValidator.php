<?hh // strict
namespace traitorous\form;

use traitorous\http\HttpRequest;
use traitorous\ImmutableMap;
use traitorous\Validation;

interface FormValidator {

    public function validate(
        ImmutableMap<string, string> $data
    ): Validation<FormErrors, bool>;

}