<?php

namespace Trigold\Udesk\Crm;

use RuntimeException;
use Trigold\Udesk\Facades\HttpClient;
use Trigold\Udesk\Exception\ParameterException;
use Trigold\Udesk\Exception\SignatureException;

class App
{
    protected $url;

    protected $email;

    protected $timestamp;

    protected $secretKey;

    protected $robot;

    protected $crm;

    public function __construct(string $url, string $email, string $secretKey)
    {
        $this->url = $url;
        $this->email = $email;
        $this->secretKey = $secretKey;
        $this->timestamp = time();

        $this->robot = new Robot($this);
    }

    public function sign(): string
    {
        return sha1(sprintf('%s&%s&%s', $this->email, $this->secretKey, $this->timestamp));
    }

    public function url($uri = '', bool $withSign = true): string
    {
        $uri = ltrim($uri, '/');
        if ($withSign) {
            $uri .= '?'.http_build_query([
                    'timestamp' => $this->timestamp, 'email' => $this->email, 'sign' => $this->sign(),
                ]);
        }
        return $uri;
    }

    /**
     * 获取语音机器人请求实例
     * @return Robot
     */
    public function robot(): Robot
    {
        return $this->robot;
    }

    /**
     * 获取业务类型
     * @return array
     */
    public function getBusinessCategories(): array
    {
        $resp = HttpClient::get($this->url('/api/v1/businessCategorys'), []);
        $decoded = json_decode($resp['body'], true);

        if ($decoded['code'] != 200) {
            throw new RuntimeException($decoded['message']);
        }
        return $decoded;
    }

    /**
     * 获取地区（省市区）信息
     * @return array
     */
    public function getAreas(): array
    {
        $resp = HttpClient::get($this->url('/api/v1/areas'), []);
        $decoded = json_decode($resp['body'], true);

        if ($decoded['code'] != 200) {
            throw new RuntimeException($decoded['message']);
        }
        return $decoded;
    }

    /**
     * 获取通话记录列表
     *
     * @param  string  $startTime
     * @param  string  $endTime
     * @param  int     $pageNum
     * @param  int     $pageSize
     *
     * @return array
     */
    public function getCallLogs(
        string $startTime,
        string $endTime,
        int $pageNum = 1,
        int $pageSize = 20
    ): array {
        $resp = HttpClient::get($this->url('/api/v1/callLogs'), []);
        $decoded = json_decode($resp['body'], true);

        if ($decoded['code'] != 200) {
            throw new RuntimeException($decoded['message']);
        }
        return $decoded;
    }

    /**
     * 获取通话记录详情
     *
     * @param $callId
     *
     * @return array
     */
    public function getCallLogsDetail($callId): array
    {
        $parameters = compact('callId');
        $resp = HttpClient::get($this->url('/api/v1/callLogs/view'), $parameters);
        $decoded = json_decode($resp['body'], true);

        if ($decoded['code'] != 200) {
            throw new RuntimeException($decoded['message']);
        }
        return $decoded;
    }

    /**
     * 获取外呼挂机原因列表
     * @return array
     */
    public function getHangupReasons(): array
    {
        $resp = HttpClient::get($this->url('/api/v1/hangupReasons'), []);
        $decoded = json_decode($resp['body'], true);

        if ($decoded['code'] != 200) {
            throw new RuntimeException($decoded['message']);
        }
        return $decoded;
    }

    /**
     * 获取主叫号码池列表
     * @return array
     */
    public function getSpNumbersPool(): array
    {
        $resp = HttpClient::get($this->app->url('/api/v1/spNumbers/spNumberPool'), []);
        $decoded = json_decode($resp['body'], true);

        if ($decoded['code'] != 200) {
            throw new RuntimeException($decoded['message']);
        }
        return $decoded;
    }

    /**
     * 回调鉴权
     *
     * @param  array  $parameters
     *
     * @return void
     * @throws ParameterException
     * @throws SignatureException
     */
    public function webHookAuth(array $parameters = [])
    {
        $uuid = $parameters['uuid'] ?? '';
        $events = $parameters['events'] ?? [];
        $timestamp = $parameters['timestamp'] ?? 0;
        $signature = $parameters['signature'] ?? '';

        if (empty($uuid) || empty($timestamp) || empty($signature) || empty($events)) {
            throw new ParameterException('parameter error');
        }

        $calSignature = sha1(sprintf('%s&%s&%s', $uuid, $this->secretKey, $timestamp));
        if ($calSignature !== $signature) {
            throw new SignatureException('signature error');
        }

        $data = $parameters['data'] ?? '';
        if (!$data) {
            throw new ParameterException('data error');
        }
    }

}
