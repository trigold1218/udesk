<?php
namespace Trigold\Udesk;

use Illuminate\Support\Arr;
use RuntimeException;
use Trigold\Udesk\Crm\App;

class Crm
{
    protected $config;

    protected $apps = [];

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function __call($method, $arguments)
    {
        return $this->app()->{$method}(...$arguments);
    }

    /**
     * @param  string|null  $name
     *
     * @return App
     */
    protected function app(?string $name = null): App
    {
        $name = $name ?: Arr::get($this->config, 'apps.crm.'.$name, 'default');
        if (! isset($this->apps[$name])) {
            if (! isset($this->config['apps']['crm'][$name])) {
                throw new RuntimeException("config 'udesk.apps.crm.{$name}' is undefined");
            }

            $config = $this->config['apps']['crm'][$name];
            $this->apps[$name] = new App($config['url'], $config['email'], $config['secret_key']);
        }
        return $this->apps[$name];
    }
}
