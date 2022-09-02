<?php
namespace Trigold\Udesk\Facades;

use Illuminate\Support\Facades\Facade;
use Trigold\Udesk\Crm\AutoCall;

/**
 * @method static array getSpNumbersPool() 获取主叫号码池列表
 * @method static AutoCall autoCall() 获取语音机器人请求实例
 */
class Crm extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'udesk.crm';
    }
}
