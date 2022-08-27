<?php

namespace Trigold\Udesk\Crm;

use RuntimeException;
use Trigold\Udesk\Facades\HttpClient;

class AutoCall
{
    protected $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    /**
     * 自动外呼-获取任务列表.
     *
     * @param  int          $pageNum   页码
     * @param  int          $pageSize  每页数量，默认20，最大50
     * @param  string|null  $name      任务名称
     * @param  int|null     $status    任务状态(1,进行中, 2,暂停中, 3,暂停, 4,完成, 5,归档)
     *
     * @return array
     */
    public function getTasks(int $pageNum = 1, int $pageSize = 10, string $name = null, int $status = null): array
    {
        $parameters = compact('pageNum', 'pageSize');
        if ($name) {
            $parameters['name'] = $name;
        }
        if ($status) {
            $parameters['status'] = $status;
        }
        $resp = HttpClient::get($this->app->url('/api/v1/autoCallTasks'), $parameters);
        $decoded = json_decode($resp['body'], true);

        if ($decoded['code'] != 200) {
            throw new RuntimeException($decoded['message']);
        }
        return [
            'paging' => $decoded['paging'] ?? [],
            'data'   => $decoded['data'] ?? [],
        ];
    }

    /**
     * @param  string  $name           任务名称
     * @param  int     $priority       优先级
     * @param  int     $userGroupId    技能组
     * @param  int     $type           任务类型(1精准,2比率,3预测,4语音)
     * @param  int     $startMode      启动方式(1手动2定时)
     * @param  int     $scheduleId     工作时间
     * @param  int     $ivrRouterId    AI话术
     * @param  string  $callOutNumber  主叫号码
     * @param  int     $callLimit      并发数
     * @param  int     $ringOutTime    振铃超时时长
     * @param  int     $spNumberType   中断号类型(1中断号2号码池)
     * @param  string  $startTime      启动时间(定时使用yyyy-MM-dd HH:mm:ss)
     * @param  string  $redialScene    挂机原因
     * @param  int     $redialTimes    重呼次数(1~6次)
     * @param  int     $redialSpace    重呼间隔类型(1呼叫单个号码后定时重呼2任务号码全部执行一次后重呼)
     * @param  string  $redialGuide    重呼间隔(1～60分钟)
     * @param  string  $remark         描述
     *
     * @return array
     */
    public function postTasks(
        string $name,
        int $priority,
        ?int $userGroupId,
        int $type,
        int $startMode,
        int $scheduleId,
        int $ivrRouterId,
        string $callOutNumber,
        int $callLimit,
        int $ringOutTime,
        int $spNumberType,
        string $startTime,
        string $redialScene = '',
        int $redialTimes = 0,
        int $redialSpace = 0,
        string $redialGuide = '',
        string $remark = ''
    ): array {
        $parameters = compact('name', 'priority', 'userGroupId', 'type', 'startMode', 'scheduleId', 'ivrRouterId',
            'callOutNumber', 'callLimit', 'ringOutTime', 'spNumberType', 'startTime');
        if ($redialScene) {
            $parameters['redialScene'] = $redialScene;
        }
        if ($redialTimes) {
            $parameters['redialTimes'] = $redialTimes;
        }
        if ($redialSpace) {
            $parameters['redialSpace'] = $redialSpace;
        }
        if ($redialGuide) {
            $parameters['redialGuide'] = $redialGuide;
        }
        if ($remark) {
            $parameters['remark'] = $redialGuide;
        }

        $resp = HttpClient::post($this->app->url('/api/v1/autoCallTasks'), $parameters);
        $decoded = json_decode($resp['body'], true);
        if ($decoded['code'] != 200) {
            throw new RuntimeException($decoded['message']);
        }
        return [
            'data' => $decoded['data'] ?? [],
        ];
    }
}
