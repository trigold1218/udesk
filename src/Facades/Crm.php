<?php
namespace Trigold\Udesk\Facades;

use Illuminate\Support\Facades\Facade;
use Trigold\Udesk\Crm\AutoCall;

/**
 * @method static array getSpNumbersPool() 获取主叫号码池列表
 * @method static array getBusinessCategories() 获取业务类型
 * @method static array getAreas() 获取地区（省市区）信息
 * @method static array getCallLogs() 获取通话记录列表
 * @method static array getCallLogsDetail() 获取通话记录详情
 * @method static array getHangupReasons() 获取外呼挂机原因列表
 * @method static AutoCall autoCall() 获取语音机器人请求实例
 */
class Crm extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'udesk.crm';
    }
}
