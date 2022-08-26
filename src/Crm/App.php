<?php
namespace Trigold\Udesk\Crm;

class App
{
    protected $url;

    protected $email;

    protected $timestamp;

    protected $secretKey;

    protected $autoCall;

    protected $crm;

    public function __construct(string $url, string $email, string $secretKey)
    {
        $this->url = $url;
        $this->email = $email;
        $this->secretKey = $secretKey;
        $this->timestamp = time();

        $this->autoCall = new AutoCall($this);
    }

    public function sign(): string
    {
        return sha1(sprintf('%s&%s&%s', $this->email, $this->secretKey, $this->timestamp));
    }

    public function url($uri = '', bool $withSign = true): string
    {
        $uri = ltrim($uri, '/');
        if ($withSign) {
            $uri .= '?' . http_build_query([
                'timestamp' => $this->timestamp, 'email' => $this->email, 'sign' => $this->sign(),
            ]);
        }
        return $uri;
    }

    public function autoCall(): AutoCall
    {
        return $this->autoCall;
    }
}
