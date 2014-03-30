<?hh // strict
namespace traitorous\render\views;

use traitorous\render\View;

include_once dirname(__FILE__) . "/../../deps/xhp/init.php";

abstract class XhpView implements View {

    abstract public function template(): :xhp;

    public function render(): string {
        return (string) $this->template();
    }

}