<?hh // strict
namespace traitorous\form;

use traitorous\http\HttpRequest;
use traitorous\form\FormErrors;
use traitorous\form\FormValidator;
use traitorous\Validation;
use traitorous\validation\Success;
use traitorous\validation\Failure;
use traitorous\Option;
use traitorous\option\Some;
use traitorous\option\None;
use traitorous\option\OptionFactory;

abstract class Form<T> {

    public function __construct(
        private ?Map<string, string> $_data = null,
        private ?FormErrors $_errors = null
    ) { }

    abstract public function validators(): FormValidator;

    abstract public function toDomainObject(Map<string, string> $data): Option<T>;

    abstract public function fromDomainObject(\T $object): this;

    public function validate(Map<string, string> $data): Validation<Form, T> {
        return $this
            ->validators()
            ->validate($data)
            ->leftMap((FormErrors $errors) ==> {
                return OptionFactory::fromValue($this->_data)->map(($original) ==> {
                    return new static(Map::fromArray(array_merge(
                        $original->toArray(),
                        $$data->toArray()
                    )), $errors);
                })->getOrElse(() ==> new static(null, $errors));
            })
            ->flatMap(($_) ==> {
                return $this->toDomainObject($data)->cata(
                    () ==> new Failure(new static(null, new FormErrors(new GeneralFormError(
                        "Failed converting form."
                    )))),
                    (\T $t) ==> new Success($t)
                );
            });
    }

    public function value(string $key): Option<string> {
        if ($this->_data === null) {
            return new None();
        } else {
            return OptionFactory::fromValue($this->_data->get($key));
        }
    }

    public function values(): Map<string, string> {
        if ($this->_data === null) {
            return new Map();
        } else {
            return $this->_data;
        }
    }

    public function errors(): Vector<FormError> {
        if ($this->_errors === null) {
            return Vector {};
        } else {
            return $this->_errors->errors();
        }
    }

}