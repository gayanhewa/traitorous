<?hh // strict
namespace traitorous\form;

interface FormError {

    public function getError(): string;

    public function cata<A>(
        (function(string, string): A) $k,
        (function(string): A) $g
    ): A;

}