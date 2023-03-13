<?php

namespace Trigold\Udesk\Laravel\Manager;

use Trigold\Udesk\Http\Guzzle;
use Illuminate\Support\Manager;
use Trigold\Udesk\App\Ccps\Ccps;

class CcpsManager extends Manager
{
    public function getDefaultDriver()
    {
        if (is_null($this->config->get('udesk.ccps.default'))) {
            throw new \InvalidArgumentException('No udesk ccps driver was specified.');
        }
        return $this->config->get('udesk.ccps.default');
    }

    /**
     * Create a new driver instance.
     *
     * @param  string  $driver
     *
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    protected function createDriver($driver)
    {
        // First, we will determine if a custom driver creator exists for the given driver and
        // if it does not we will check for a creator method for the driver. Custom creator
        // callbacks allow developers to build their own "drivers" easily using Closures.
        if (isset($this->customCreators[$driver])) {
            return $this->callCustomCreator($driver);
        }

        return $this->createCcpsDriver($driver);
    }

    protected function createCcpsDriver($driver = ''): Ccps
    {
        $config = $this->config->get("udesk.ccps.apps.$driver");
        $url = $this->config->get("udesk.ccps.url");
        if (is_null($config)) {
            throw new \InvalidArgumentException(sprintf('Unable to resolve NULL driver for [%s].', static::class));
        }
        $timeout = $this->config->get("udesk.timeout") ?? 2;
        $httpOptions = $this->config->get("udesk.http.options") ?? [];
        return new Ccps($config['email'], $config['appId'], $config['secret'],
            new Guzzle($url, $timeout, $httpOptions));
    }
}
