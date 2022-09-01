<?php

namespace Trigold\Udesk\Http;

use GuzzleHttp\Client;
use Trigold\Udesk\Contracts\HttpClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;

class Guzzle implements HttpClient
{
    protected $client;

    protected $options;

    public function __construct(string $baseUri = '', int $timeout = 2, array $options = [])
    {
        $this->client = new Client([
            'base_uri' => $baseUri,
            'timeout'  => $timeout,
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

        $uri .= (strpos($uri, '?') === false ? '?' : '&').http_build_query($data);
        try {
            $response = $this->client->get($uri, $this->options);
        } catch (ClientException $e) {
            return [
                'header'   => $e->getHandlerContext(),
                'body'     => $e->getResponse()->getBody()->getContents(),
                'httpCode' => $e->getCode(),
            ];
        }

        return [
            'header'   => $response->getHeaders(),
            'body'     => $response->getBody()->getContents(),
            'httpCode' => $response->getStatusCode(),
        ];
    }

    /**
     * post请求
     *
     * @param  string  $uri
     * @param  array   $data
     *
     * @return array
     * @throws
     */
    public function post(string $uri, array $data = []): array
    {
        try {
            $response = $this->client->post($uri, [
                'json' => $data,
            ]);
        } catch (ClientException $e) {
            return [
                'header'   => $e->getHandlerContext(),
                'body'     => $e->getResponse()->getBody()->getContents(),
                'httpCode' => $e->getCode(),
            ];
        }
        return [
            'header'   => $response->getHeaders(),
            'body'     => $response->getBody()->getContents(),
            'httpCode' => $response->getStatusCode(),
        ];
    }

    /**
     * @param  string  $uri
     * @param  array   $data
     *
     * @return array
     */
    public function put(string $uri, array $data = []): array
    {
        try {
            try {
                $response = $this->client->put($uri, [
                    'json' => $data,
                ]);
            } catch (ClientException $e) {
                return [
                    'header'   => $e->getHandlerContext(),
                    'body'     => $e->getResponse()->getBody()->getContents(),
                    'httpCode' => $e->getCode(),
                ];
            }
        } catch (GuzzleException $e) {
            return [
                'header'   => null,
                'body'     => $e->getMessage(),
                'httpCode' => $e->getCode(),
            ];
        }
        return [
            'header'   => $response->getHeaders(),
            'body'     => $response->getBody()->getContents(),
            'httpCode' => $response->getStatusCode(),
        ];
    }

    public function delete(string $uri, array $data = []): array
    {
        try {
            try {
                $response = $this->client->delete($uri, [
                    'json' => $data,
                ]);
            } catch (ClientException $e) {
                return [
                    'header'   => $e->getHandlerContext(),
                    'body'     => $e->getResponse()->getBody()->getContents(),
                    'httpCode' => $e->getCode(),
                ];
            }
        } catch (GuzzleException $e) {
            return [
                'header'   => null,
                'body'     => $e->getMessage(),
                'httpCode' => $e->getCode(),
            ];
        }
        return [
            'header'   => $response->getHeaders(),
            'body'     => $response->getBody()->getContents(),
            'httpCode' => $response->getStatusCode(),
        ];
    }
}
