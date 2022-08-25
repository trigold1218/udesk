<?php
namespace Trigold\Udesk\Http;

use GuzzleHttp\Client;
use Trigold\Udesk\Contracts\HttpClient;

class Guzzle implements HttpClient
{
    protected $client;

    protected $options;

    public function __construct(string $baseUri = '', int $timeout = 2, array $options = [])
    {
        $this->client = new Client([
            'base_uri' => $baseUri,
            'timeout' => $timeout,
        ]);
        $this->options = $options;
    }

    /**
     * @param  string  $uri
     * @param  array   $data
     *
     * @return array
     * @throws
     */
    public function get(string $uri, array $data): array
    {
        $uri .= (strpos($uri, '?') === false ? '?' : '&') . http_build_query($data);
        $response = $this->client->get($uri, $this->options);

        return [
            'header' => $response->getHeaders(),
            'body' => $response->getBody()->getContents(),
            'httpCode' => $response->getStatusCode(),
        ];
    }

    /**
     * post请求
     * @param  string  $uri
     * @param  array   $data
     *
     * @return array
     * @throws
     */
    public function post(string $uri, array $data = []): array
    {
        $response = $this->client->post($uri, [
            'json' => $data,
        ], $this->options);

        return [
            'header' => $response->getHeaders(),
            'body' => $response->getBody()->getContents(),
            'httpCode' => $response->getStatusCode(),
        ];
    }
}
