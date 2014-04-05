<?hh // strict
require("../vendor/autoload.php");

use \traitorous\form\Form;
use \traitorous\form\FormValidator;
use \traitorous\form\validators\ParallelFormValidators;
use \traitorous\form\validators\SequenceFormValidators;
use \traitorous\form\validators\KeyedFormValidators;
use \traitorous\form\validators\RequiredFormValidator;
use \traitorous\form\validators\EmailFormValidator;
use \traitorous\form\validators\MinLengthFormValidator;
use \traitorous\http\handlers\Controller;
use \traitorous\http\handlers\HttpRouteMiddleware;
use \traitorous\http\HttpRequest;
use \traitorous\http\HttpResponse;
use \traitorous\http\HttpRequestHandler;
use \traitorous\http\methods\HttpGetMethod;
use \traitorous\http\methods\HttpPostMethod;
use \traitorous\http\HttpRouter;
use \traitorous\http\responses\OkResponse;
use \traitorous\http\HttpResponseConsumer;
use \traitorous\http\routes\HttpRouteRule;
use \traitorous\http\routes\rules\PathRule;
use \traitorous\http\routes\rules\CatchAllRule;
use \traitorous\http\routes\rules\HttpRouteRules;
use \traitorous\http\routes\rules\MethodRule;
use \traitorous\matcher\string\StringLiteralMatcher;
use \traitorous\matcher\string\StringRegexMatcher;
use \traitorous\render\views\StringView;
use \traitorous\render\views\XhpView;
use \traitorous\Option;
use \traitorous\option\Some;
use \traitorous\option\None;
use \traitorous\option\OptionFactory;

use \traitorous\ImmutableVector;
use \traitorous\ImmutableMap;

abstract class Layout extends XhpView {

    abstract public function content(): :xhp;

    public function template(): :xhp {
        return
            <x:doctype>
                <html>
                    <head>
                        <title>Traitorous Framework</title>
                    </head>
                    <body>
                        {$this->content()}
                    </body>
                </html>
            </x:doctype>;
    }

}

final class IndexView extends Layout {

    public function content(): :xhp {
        return
            <div id="content">
                Hello from the index controller!
            </div>;
    }

}

final class Index extends Controller {

    public function route(): HttpRouteRule {
        return new HttpRouteRules(Vector {
            new MethodRule(new HttpGetMethod()),
            new PathRule(new StringLiteralMatcher("/"))
        });
    }

    public function handle(HttpRequest $request): HttpResponse {
        $response = new OkResponse(new IndexView());
        $session  = $request->session("secret");
        $visits   = $session->get("visits")->map(($n) ==> (int) $n)->getOrDefault(0);
        return $response->withSession($session->set("visits", $visits + 1));
    }

}

final class Regex extends Controller {

    public function middleware(): Vector<HttpRouteMiddleware> {
        return Vector {
            new PreMiddleware(),
            new PostMiddleware()
        };
    }

    public function route(): HttpRouteRule {
        return new HttpRouteRules(Vector {
            new MethodRule(new HttpGetMethod()),
            new PathRule(new StringRegexMatcher("/\\/test\\/.*/"))
        });
    }

    public function handle(HttpRequest $request): HttpResponse {
        return new OkResponse(new StringView("Hello from regex controller!"));
    }

}

final class Login extends Controller {

    public function route(): HttpRouteRule {
        return new HttpRouteRules(Vector {
            new MethodRule(new HttpPostMethod()),
            new PathRule(new StringLiteralMatcher("/login"))
        });
    }

    public function handle(HttpRequest $request): HttpResponse {
        $form   = new LoginForm();
        $result = $form->validate($request->getPostParamMap());
        return $result->cata(
            (LoginForm $formWithErrors) ==>
                new OkResponse(new StringView(print_r($formWithErrors, true))),
            (LoginData $n) ==>
                new OkResponse(new StringView("Form validated!\n"))
        );
    }

}

final class LoginData {

    public function __construct(
        private string $_email,
        private string $_password
    ) { }

    public function getEmail(): string {
        return $this->_emai;
    }

    public function getPassword(): string {
        return $this->_password;
    }

}

final class LoginForm extends Form<LoginData> {

    public function validators(): FormValidator {
        return new SequenceFormValidators(Vector {
            new ParallelFormValidators(Vector {
                new KeyedFormValidators("email", Vector {
                    new RequiredFormValidator("You must enter an email address."),
                    new EmailFormValidator("You must enter a valid email address.")
                }),
                new KeyedFormValidators("password", Vector {
                    new RequiredFormValidator("You must enter a password.")
                })
            }),
            new KeyedFormValidators("password", Vector {
                new MinLengthFormValidator(7, "Invalid email/password combination.")
            })
        });
    }

    public function toDomainObject(ImmutableMap<string, string> $data): Option<LoginData> {
        return $data->get("email")->flatMap(($email) ==> {
            return $data->get("password")->map(($password) ==> {
                return new LoginData($email, $password);
            });
        });
    }

    public function fromDomainObject(LoginData $object): this {
        return new LoginForm($object->getEmail(), $object->getPassword());
    }

}

final class Missing extends Controller {

    public function route(): HttpRouteRule {
        return new CatchAllRule();
    }

    public function handle(HttpRequest $request): HttpResponse {
        return new OkResponse(new StringView("Unable to find specified route"));
    }

}

final class PreMiddleware extends HttpRouteMiddleware {

    public function intercept(HttpRequest $request,
                              HttpRequestHandler $next): HttpResponse
    {
        echo "[pre] ";
        return $next->handle($request);
    }

}

final class PostMiddleware extends HttpRouteMiddleware {

    public function intercept(HttpRequest $request,
                              HttpRequestHandler $next): HttpResponse
    {
        return new OkResponse(
            new StringView($next->handle($request)->view()->render() . " [post]")
        );
    }

}

$test1 = new ImmutableVector();
$test2 = new ImmutableMap();

$request  = new HttpRequest();
$consumer = new HttpResponseConsumer();

$router = new HttpRouter(Vector {
    new Index(),
    new Regex(),
    new Login()
});

/** @var HttpRequestHandler $route */
$route = $router
    ->route($request)
    ->getOrElse(() ==> new Missing());

echo $consumer->consume($route->apply($request));
