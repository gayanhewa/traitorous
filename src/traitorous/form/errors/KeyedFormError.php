<?hh // strict
namespace traitorous\form\errors;

use traitorous\form\FormError;

final class KeyedFormError implements FormError {

    public function __construct(
        private string $_key,
        private string $_error
    ) { }

    public function getError(): string {
        return $this->_error;
    }

    public function getKey(): string {
        return $this->_key;
    }

    public function cata<T>(
        (function(string, string): T) $k,
        (function(string): T) $g
    ): T
    {
        return $k($this->_key, $this->_error);
    }

}