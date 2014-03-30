<?hh // strict
namespace traitorous\form\validators;

use traitorous\form\FormValidator;
use traitorous\form\KeyedFormValidator;
use traitorous\form\FormErrors;
use traitorous\form\errors\KeyedFormError;
use traitorous\http\HttpRequest;
use traitorous\option\OptionFactory;
use traitorous\Validation;
use traitorous\validation\Failure;
use traitorous\validation\Success;

final class KeyedFormValidators implements FormValidator {

    public function __construct(
        private string $_key,
        private Vector<KeyedFormValidator> $_validators
    ) { }

    public function validate(Map<string, string> $data): Validation<FormErrors, bool> {
        return array_reduce(
            $this->_validators->toArray(),
            (Validation<KeyedFormError, bool> $s, KeyedFormValidator $v) ==> {
                $value = OptionFactory::fromValue($data->get($this->_key));
                return $s->flatMap(($_) ==> $v->validate($this->_key, $value));
            },
            new Success(true)
        );
    }

}