<?hh // strict
namespace traitorous\form\validators;

use traitorous\form\errors\GeneralFormError;
use traitorous\form\FormErrors;
use traitorous\form\FormValidator;
use traitorous\ImmutableMap;
use traitorous\matcher\string\StringRegexMatcher;
use traitorous\Option;
use traitorous\option\OptionFactory;
use traitorous\Validation;
use traitorous\validation\Failure;
use traitorous\validation\Success;

final class ValuesMatchFormValidator implements FormValidator {

    public function __construct(
        private string $_k1,
        private string $_k2,
        private string $_errorMessage
    ) { }

    public function validate(
        ImmutableMap<string, string> $data
    ): Validation<FormErrors, bool> {
        $tuple    = $this->_getTuplePair($data);
        $filtered = $tuple->filter(($t) ==> $t[0] == $t[1]);
        invariant($filtered instanceof Option, "Expected to return Option");
        return $filtered->cata(
            ()   ==> new Failure(new FormErrors(Vector { new GeneralFormError($this->_errorMessage) })),
            ($_) ==> new Success(true)
        );
    }

    private function _getTuplePair(ImmutableMap<string, string> $data): Option<(string, string)> {
        $result = $data->get($this->_k1)->flatMap(($v1) ==> {
            $o = $data->get($this->_k2)->map(($v2) ==> tuple($v1, $v2));
            invariant($o instanceof Option, "Expected an Option<T>");
            return $o;
        });
        invariant($result instanceof Option, "Expected to return an Option");
        return $result;
    }

}