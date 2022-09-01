<?php

namespace Trigold\Udesk\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Trigold\Udesk\Http
 * @method static mixed get(string $url = '', array $data = [])
 * @method static mixed post(string $url, array $data = [])
 * @method static mixed put(string $url, array $data = [])
 * @method static mixed delete(string $url, array $data = [])
 * method static string upload(string $url, array $data = [])
 */
class HttpClient extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return 'udesk.http.client';
    }
}
