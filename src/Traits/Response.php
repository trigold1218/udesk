<?php

namespace Trigold\Udesk\Traits;

use InvalidArgumentException;

trait Response
{
    public function response($response):array
    {
        $decoded = json_decode($response['body'], true);

        if (empty($decoded)) {
            throw new InvalidArgumentException(json_encode($response));
        }

        if (!empty($decoded['code']) && $decoded['code'] != 200 || !empty($decoded['status']) && $decoded['status'] != 200) {
            throw new InvalidArgumentException($decoded['message']);
        }

        return $decoded;
    }
}
