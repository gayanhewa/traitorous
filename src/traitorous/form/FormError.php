<?hh // strict
namespace traitorous\form;

interface FormError {

    public function getError(): string;

    public function cata<T>(
        (function(string, string): T) $k,
        (function(string): T) $g
    ): T;

}