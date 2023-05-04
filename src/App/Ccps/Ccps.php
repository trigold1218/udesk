<?php

namespace Trigold\Udesk\App\Ccps;

use Trigold\Udesk\Http\Guzzle;
use Trigold\Udesk\Contracts\HttpClient;

class Ccps
{
    protected int $timestamp;

    protected string $email;

    // default url
    protected string $url = 'https://ccps.s4.udesk.cn';

    protected string $appId;

    protected string $secret;

    protected Robot $robot;

    public HttpClient $client;

    public function __construct(string $email, string $appId, string $secret, ?HttpClient $client)
    {
        $this->email = $email;
        $this->appId = $appId;
        $this->secret = $secret;
        $this->timestamp = time();
        $this->client = $client??new Guzzle($this->url);
    }

    public function robot(): Robot
    {
        if (!empty($this->robot)) {
            return $this->robot;
        }
        $this->robot = new Robot($this);
        return $this->robot;
    }

    protected function token(): string
    {
        return hash_hmac('sha1', $this->appId.$this->timestamp, $this->secret);
    }

    public function url($uri = '', bool $withSign = true): string
    {
        $uri = ltrim($uri, '/');
        if ($withSign) {
            $uri .= '?'.http_build_query([
                    'Email'     => $this->email,
                    'AppId'     => $this->appId,
                    'Timestamp' => $this->timestamp,
                    'Token'     => $this->token(),
                ]);
        }
        return $uri;
    }
}
