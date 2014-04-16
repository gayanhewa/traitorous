<?hh // strict
namespace traitorous\either;

use traitorous\Either;

interface ProjectableToEither<Tr> {

    public function toRight<Ta>((function():Ta) $left): Either<Ta, Tr>;

    public function toLeft<Ta>((function():Ta) $right): Either<Tr, Ta>;

}
