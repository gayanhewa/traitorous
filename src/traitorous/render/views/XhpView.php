<?hh // partial
namespace traitorous\render\views;

use traitorous\render\View;

abstract class XhpView implements View {

    abstract public function template(): :xhp;

    public function render(): string {
        return (string) $this->template();
    }

}