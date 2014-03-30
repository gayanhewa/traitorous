<?hh // strict
namespace traitorous\http;

abstract class HttpHeader {

    public function __construct(private string $_value) { }

    abstract public function getKey(): string;

    public function getValue(): string {
        return $this->_value;
    }

}