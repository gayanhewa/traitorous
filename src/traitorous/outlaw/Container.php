<?hh // strict
namespace traitorous\outlaw;

interface Container {

    public function length(): int;

    public function isEmpty(): bool;

    public function nonEmpty(): bool;

}