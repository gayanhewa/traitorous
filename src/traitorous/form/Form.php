<?hh // strict
namespace traitorous\form;

use traitorous\http\HttpRequest;
use traitorous\form\FormErrors;
use traitorous\form\FormValidator;
use traitorous\form\errors\GeneralFormError;
use traitorous\ImmutableMap;
use traitorous\Validation;
use traitorous\validation\Success;
use traitorous\validation\Failure;
use traitorous\Option;
use traitorous\option\Some;
use traitorous\option\None;
use traitorous\option\OptionFactory;

abstract class Form<T> {

    public function __construct(
        private ?ImmutableMap<string, string> $_data = null,
        private ?FormErrors $_errors = null
    ) { }

    abstract public function validators(): FormValidator;

    abstract public function toDomainObject(ImmutableMap<string, string> $data): Option<T>;

    abstract public function fromDomainObject(T $object): this;

    public function validate(ImmutableMap<string, string> $data): Validation<Form<T>, T> {
        // UNSAFE
        return $this
            ->validators()
            ->validate($data)
            ->leftMap(($errors) ==> {
                return OptionFactory::fromValue($this->_data)->map(($original) ==> {
                    return new static(new ImmutableMap(array_merge(
                        $original->toArray(),
                        $data->toArray()
                    )), $errors);
                })->getOrElse(() ==> new static(null, $errors));
            })
            ->flatMap(($_) ==> {
                return $this->toDomainObject($data)->cata(
                    () ==> new Failure(new static(null, new FormErrors(Vector {
                        new GeneralFormError("Failed converting form.")
                    }))),
                    ($t) ==> new Success($t)
                );
            });
    }

    public function value(string $key): Option<string> {
        if ($this->_data === null) {
            return new None();
        } else {
            return $this->_data->get($key);
        }
    }

    public function values(): ImmutableMap<string, string> {
        if ($this->_data === null) {
            return new ImmutableMap();
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

    public static function fromError(string $error): Form<T> {
        return new static(null, new FormErrors(Vector {
            new GeneralFormError($error)
        }));
    }

}