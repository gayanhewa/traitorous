<?hh // strict
namespace traitorous\http;

use traitorous\ImmutableMap;
use traitorous\Option;
use traitorous\option\Some;
use traitorous\option\None;

final class Session {

    public function __construct(
        private string $_secret,
        private ImmutableMap<string, string> $_data
    ) { }

    public function secret(): string {
        return $this->_secret;
    }

    public function data(): ImmutableMap<string, string> {
        return $this->_data;
    }

    public function withFreshData(ImmutableMap<string, string> $data): Session {
        return new Session($this->_secret, $data);
    }

    public function withData(ImmutableMap<string, string> $data): Session {
        return new Session($this->_secret, $this->_data->add($data));
    }

    public function set($key, $value): Session {
        $arr = [];
        $arr[$key] = $value;
        return $this->withData(new ImmutableMap($arr));
    }

    public function get(string $key): Option<string> {
        return $this->_data->get($key);
    }

    public function clear(): Session {
        return new Session($this->_secret, $data);
    }

    public function toJson(): string {
        return json_encode($this->_data->toArray());
    }

    public function signature(): string {
        return Session::sessionSignature($this->_secret, $this->_data);
    }

    public static function fromRequest(string $secret, HttpRequest $request): Session {
        return $request
            ->getHeadersObject()
            ->get("cookie")
            ->map(($header) ==> Cookie::parse($header))
            ->flatMap(($cookies) ==> $cookies->get("session"))
            ->flatMap(Session::genSessionVerifier($secret))
            ->getOrElse(() ==> new Session($secret, new ImmutableMap()));
    }

    public static function genSessionVerifier(string $key): (function(string): Option<ImmutableMap<string, string>>) {
        return ($session) ==> {
            try {
                $supplied  = substr($session, 0, 64);
                $session   = new ImmutableMap(json_decode(substr($session, 64), true));
                $generated = Session::sessionSignature($key, $session);
                if ($supplied === $generated) {
                    return new Some(new Session($key, $session));
                } else {
                    return new None();
                }
            } catch (\Exception $e) {
                return new None();
            }
        };
    }

    public function sessionSignature(string $key, ImmutableMap<string, string> $session): string {
        $keys = $session->keys()->toArray();
        sort($keys);
        return hash_hmac(
            "sha256",
            array_reduce($keys, ($m, $n) ==> $m . $n . $session->get($n)->getOrDefault(""), ""),
            $key
        );
    }

}