<?hh // strict
namespace traitorous\form;

use traitorous\http\HttpRequest;
use traitorous\Validation;

interface FormValidator {

    public function validate(Map<string, string> $data): Validation<FormErrors, bool>;

}