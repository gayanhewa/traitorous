<?hh // strict
namespace traitorous\render\views;

use traitorous\render\View;

class StringView implements View {

    public function __construct(private string $_string) { }

    public function render(): string {
        return $this->_string;
    }

}