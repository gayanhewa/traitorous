<?hh // strict
namespace traitorous\validation;

use traitorous\Validation;

interface ProjectableToValidation<Ts> {

    public function toSuccess<Ta>((function():Ta) $failure): Validation<Ta, Ts>;

    public function toFailure<Ta>((function():Ta) $success): Validation<Ts, Ta>;

}
