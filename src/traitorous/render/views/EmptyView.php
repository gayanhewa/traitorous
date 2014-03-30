<?hh // strict
namespace traitorous\render\views;

use traitorous\render\View;

class EmptyView implements View {

    public function render(): string {
        return "";
    }

}