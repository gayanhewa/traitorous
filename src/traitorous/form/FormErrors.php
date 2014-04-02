<?hh // strict
namespace traitorous\form;

use traitorous\form\FormError;
use traitorous\algebraic\Monoid;
use traitorous\outlaw\Add;

final class FormErrors implements Monoid {

    public function __construct(private Vector<FormError> $_errors) { }

    public function zero(): FormErrors {
        return new FormErrors(Vector {});
    }

    public function add(Add $other): FormErrors {
        invariant($other instanceof FormErrors, "Must receive a FormErrors");
        return new FormErrors(Vector::fromArray(array_merge(
            $this->_errors->toArray(),
            $other->errors()->toArray()
        )));
    }

    public function withError(FormError $error): FormErrors {
        return new FormErrors(Vector::fromArray(array_merge(
            $this->_errors->toArray(),
            [$error]
        )));
    }

    public function errors(): Vector<FormError> {
        return $this->_errors;
    }

}