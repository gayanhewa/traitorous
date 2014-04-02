<?hh // strict
namespace traitorous\form\errors;

use traitorous\form\FormError;

final class GeneralFormError implements FormError {

    public function __construct(private string $_error) { }

    public function getError(): string {
        return $this->_error;
    }

    public function cata<T>(
        (function(string, string): T) $k,
        (function(string): T) $g
    ): T
    {
        return $g($this->_error);
    }

}