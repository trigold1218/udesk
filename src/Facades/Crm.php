<?php
namespace Trigold\Udesk\Facades;

use Illuminate\Support\Facades\Facade;
use Trigold\Udesk\Crm\AutoCall;

/**
 * @method static AutoCall autoCall()
 */
class Crm extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'udesk.crm';
    }
}
