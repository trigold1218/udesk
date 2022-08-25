<?php
namespace Trigold\Udesk\Contracts;

interface HttpClient
{
    public function __construct(string $baseUri = '', int $timeout = 2);
    public function get(string $uri, array $data);
    public function post(string $uri, array $data);
}
