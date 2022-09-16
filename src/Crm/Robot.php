<?php
/**
 * This file is part of mas.
 *
 * @link     https://code.addcn.com
 * @document https://code.addcn.com/8591/mas/blob/master/README.md
 * @contact  hdj@addcn.com
 * @license  https://code.addcn.com/8591/mas/blob/master/LICENSE
 */

namespace Trigold\Udesk\Crm;

use RuntimeException;
use Trigold\Udesk\Facades\HttpClient;

class Robot
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
     * @param  null|string  $name      任务名称
     * @param  null|int     $status    任务状态(1,进行中, 2,暂停中, 3,暂停, 4,完成, 5,归档)
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
        return $decoded;
    }

    /**
     * 创建任务接口.
     *
     * @param  string    $name           任务名称
     * @param  int       $priority       优先级
     * @param  null|int  $userGroupId    技能组
     * @param  int       $type           任务类型(1精准,2比率,3预测,4语音)
     * @param  int       $startMode      启动方式(1手动2定时)
     * @param  int       $scheduleId     工作时间
     * @param  int       $ivrRouterId    AI话术
     * @param  string    $calloutNumber  主叫号码
     * @param  int       $callLimit      并发数
     * @param  int       $ringOutTime    振铃超时时长
     * @param  int       $spNumberType   中断号类型(1中断号2号码池)
     * @param  string    $startTime      启动时间(定时使用yyyy-MM-dd HH:mm:ss)
     * @param  string    $redialScene    挂机原因
     * @param  int       $redialTimes    重呼次数(1~6次)
     * @param  int       $redialSpace    重呼间隔类型(1呼叫单个号码后定时重呼2任务号码全部执行一次后重呼)
     * @param  string    $redialGuide    重呼间隔(1～60分钟)
     * @param  string    $remark         描述
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
        string $calloutNumber,
        int $callLimit,
        int $ringOutTime,
        int $spNumberType,
        string $startTime = '',
        string $redialScene = '',
        int $redialTimes = 0,
        int $redialSpace = 0,
        string $redialGuide = '',
        string $remark = ''
    ): ?array {
        $parameters = compact(
            'name',
            'priority',
            'userGroupId',
            'type',
            'startMode',
            'scheduleId',
            'ivrRouterId',
            'calloutNumber',
            'callLimit',
            'ringOutTime',
            'spNumberType',
            'startTime'
        );
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
        if ($startTime) {
            $parameters['startTime'] = $startTime;
        }

        $resp = HttpClient::post($this->app->url('/api/v1/autoCallTasks'), $parameters);
        $decoded = json_decode($resp['body'], true);
        if ($decoded['code'] != 200) {
            throw new RuntimeException($decoded['message']);
        }
        return $decoded;
    }

    /**
     * 获取指定任务详情接口.
     *
     * @param  int  $id  任务id
     *
     * @return array
     */
    public function getCallTasksById(int $id): ?array
    {
        $resp = HttpClient::get($this->app->url('/api/v1/autoCallTasks/'.$id), []);
        $decoded = json_decode($resp['body'], true);
        if ($decoded['code'] != 200) {
            throw new RuntimeException($decoded['message']);
        }
        return $decoded;
    }

    /**
     * 更新任务接口.
     *
     * @param  int     $id             任务id
     * @param  string  $name           任务名称
     * @param  int     $priority       优先级
     * @param  int     $startMode      启动方式(1手动2定时)
     * @param  int     $scheduleId     工作时间
     * @param  string  $calloutNumber  主叫号码
     * @param  int     $callLimit      并发数
     * @param  int     $ringOutTime    振铃超时时长
     * @param  int     $spNumberType   中断号类型(1中断号2号码池)
     * @param  string  $startTime      启动时间(定时使用yyyy-MM-dd HH:mm:ss)
     * @param  string  $remark         描述
     *
     * @return array
     */
    public function updateCallTasks(
        int $id,
        string $name,
        int $priority,
        int $startMode,
        int $scheduleId,
        string $calloutNumber,
        int $callLimit,
        int $ringOutTime,
        int $spNumberType,
        string $startTime = '',
        string $remark = ''
    ): ?array {
        $parameters = compact(
            'name',
            'priority',
            'startMode',
            'scheduleId',
            'calloutNumber',
            'callLimit',
            'ringOutTime',
            'spNumberType'
        );

        if ($startTime) {
            $parameters['startTime'] = $startTime;
        }
        if ($remark) {
            $parameters['remark'] = $remark;
        }

        $resp = HttpClient::put($this->app->url('/api/v1/autoCallTasks/'.$id), $parameters);
        $decoded = json_decode($resp['body'], true);
        if ($decoded['code'] != 200) {
            throw new RuntimeException($decoded['message']);
        }
        return $decoded;
    }

    /**
     * 启动任务接口.
     *
     * @param  int  $id  任务id
     *
     * @return array
     */
    public function startCallTasks(int $id): ?array
    {
        $parameters = compact('id');
        $resp = HttpClient::post($this->app->url('/api/v1/autoCallTasks/status/start/').'&id='.$id, $parameters);
        $decoded = json_decode($resp['body'], true);
        if ($decoded['code'] != 200) {
            throw new RuntimeException($decoded['message']);
        }
        return $decoded;
    }

    /**
     * 暂停任务接口.
     *
     * @param  int  $id  任务id
     *
     * @return array
     */
    public function pauseCallTasks(int $id): ?array
    {
        $resp = HttpClient::post($this->app->url('/api/v1/autoCallTasks/status/pause')."&id={$id}", []);
        $decoded = json_decode($resp['body'], true);
        if ($decoded['code'] != 200) {
            throw new RuntimeException($decoded['message']);
        }
        return $decoded;
    }

    /**
     * 归档任务接口.
     *
     * @param  int  $id  任务id
     *
     * @return array
     */
    public function archiveCallTasks(int $id): ?array
    {
        $resp = HttpClient::post($this->app->url('/api/v1/autoCallTasks/status/archive')."&id={$id}");
        $decoded = json_decode($resp['body'], true);
        if ($decoded['code'] != 200) {
            throw new RuntimeException($decoded['message']);
        }
        return $decoded;
    }

    /**
     * @param  int       $outboundTaskId      任务ID
     * @param  int       $pageNum             页码
     * @param  int       $pageSize            每页数量，默认20，最大50
     * @param  int|null  $callResult          最近外呼结果(1已接通, 2未接通, 7未拨打)
     * @param  int|null  $durationMin         通话时长左值
     * @param  int|null  $durationMax         通话时长右值
     * @param  int|null  $talkTurn            对话轮次
     * @param  string    $redialTimeStartStr  查询拨号开始时间(例：2019-01-01 13:01:01)
     * @param  string    $redialTimeEndStr    查询拨号结止时间(例：2019-01-01 15:01:01)
     *
     * @return array
     */
    public function getCallTasksNumber(
        int $outboundTaskId,
        int $pageNum = 1,
        int $pageSize = 20,
        int $callResult = null,
        int $durationMin = null,
        int $durationMax = null,
        int $talkTurn = null,
        string $redialTimeStartStr = '',
        string $redialTimeEndStr = ''
    ): ?array {
        $parameters = compact(
            'outboundTaskId',
            'callResult',
            'durationMin',
            'durationMax',
            'talkTurn',
            'pageNum',
            'pageSize'
        );

        if ($redialTimeStartStr) {
            $parameters['redialTimeStartStr'] = $redialTimeStartStr;
        }
        if ($redialTimeEndStr) {
            $parameters['redialTimeEndStr'] = $redialTimeEndStr;
        }

        $resp = HttpClient::get($this->app->url('/api/v1/autoCallTasks/number'), $parameters);
        $decoded = json_decode($resp['body'], true);
        if ($decoded['code'] != 200) {
            throw new RuntimeException($decoded['message']);
        }
        return $decoded;
    }

    /**
     * @param  int  $numberId  号码ID
     *
     * @return array
     */
    public function getCallTasksNumberByNumberId(int $numberId): ?array
    {
        $parameters = compact('numberId');
        $resp = HttpClient::get($this->app->url('/api/v1/autoCallTasks/number/'.$numberId));
        $decoded = json_decode($resp['body'], true);
        if ($decoded['code'] != 200) {
            throw new RuntimeException($decoded['message']);
        }
        return $decoded;
    }

    /**
     * 向任务中导入客户接口(同步).
     *
     * @param  int      $outboundTaskId  任务ID
     * @param  int      $dealType        重复处理类型(1全局2所有任务3当前任务4不查重)
     * @param  array[]  $numberList      号码数组
     *                                   name       姓名
     *                                   mobile     号码数组
     *                                   remark     备注
     *                                   variates   自定义变量(格式:[{"key":"weather","type":"string","value":"北京"}])
     */
    public function callTasksSyncNumber(int $outboundTaskId, int $dealType, array $numberList): ?array
    {
        $parameters = compact('outboundTaskId', 'dealType', 'numberList');
        $resp = HttpClient::post($this->app->url('/api/v1/autoCallTasks/syncNumber'), $parameters);
        $decoded = json_decode($resp['body'], true);
        if ($decoded['code'] != 200) {
            throw new RuntimeException($decoded['message']);
        }
        return $decoded;
    }

    /**
     * 向任务中导入客户接口(异步).
     *
     * @param  int      $outboundTaskId  任务ID
     * @param  int      $dealType        重复处理类型(1全局2所有任务3当前任务4不查重)
     * @param  array[]  $numberList      号码数组
     *                                   name       姓名
     *                                   mobile     号码数组
     *                                   remark     备注
     *                                   variates   自定义变量(格式:[{"key":"weather","type":"string","value":"北京"}])
     */
    public function callTasksAsyncNumber(int $outboundTaskId, int $dealType, array $numberList): ?array
    {
        $parameters = compact('outboundTaskId', 'dealType', 'numberList');
        $resp = HttpClient::post($this->app->url('/api/v1/autoCallTasks/asyncNumber'), $parameters);
        $decoded = json_decode($resp['body'], true);
        if ($decoded['code'] != 200) {
            throw new RuntimeException($decoded['message']);
        }
        return $decoded;
    }

    /**
     * 查询异步导入客户结果接口.
     *
     * @return mixed
     */
    public function getCallTasksSyncNumberResult(int $outboundTaskId, string $batchId): array
    {
        $parameters = compact('outboundTaskId', 'batchId');
        $resp = HttpClient::post($this->app->url('/api/v1/autoCallTasks/syncNumberResult'), $parameters);
        $decoded = json_decode($resp['body'], true);
        if ($decoded['code'] != 200) {
            throw new RuntimeException($decoded['message']);
        }
        return $decoded;
    }

    /**
     * 设置异步导入客户回调webhook地址
     */
    public function setTargetUrls(string $payloadUrl, int $id = null): array
    {
        $parameters = compact('payloadUrl');
        if ($id) {
            $parameters['id'] = $id;
        }
        $resp = HttpClient::post($this->app->url('/api/v1/targetUrls'), $parameters);
        $decoded = json_decode($resp['body'], true);
        if ($decoded['code'] != 200) {
            throw new RuntimeException($decoded['message']);
        }
        return $decoded;
    }

    /**
     * 获取中继号码列表.
     */
    public function getSpNumbers(): array
    {
        $resp = HttpClient::get($this->app->url('/api/v1/spNumbers'), []);
        $decoded = json_decode($resp['body'], true);

        if ($decoded['code'] != 200) {
            throw new RuntimeException($decoded['message']);
        }
        return $decoded;
    }

    /**
     * 获取工作时间列表.
     */
    public function getWorkTimes(): array
    {
        $resp = HttpClient::get($this->app->url('/api/v1/worktimes'), []);
        $decoded = json_decode($resp['body'], true);

        if ($decoded['code'] != 200) {
            throw new RuntimeException($decoded['message']);
        }
        return $decoded;
    }

    /**
     * 获取话术列表.
     */
    public function getSpeechTechniques(): array
    {
        $resp = HttpClient::get($this->app->url('/api/v1/speechTechniques'), []);
        $decoded = json_decode($resp['body'], true);

        if ($decoded['code'] != 200) {
            throw new RuntimeException($decoded['message']);
        }
        return $decoded;
    }

    /**
     * 获取字段模板列表接口.
     */
    public function getOutboundCustomFieldTemplates(): array
    {
        $resp = HttpClient::get($this->app->url('/api/v1/outboundCustomFieldTemplates'), []);
        $decoded = json_decode($resp['body'], true);

        if ($decoded['code'] != 200) {
            throw new RuntimeException($decoded['message']);
        }
        return $decoded;
    }

    /**
     * 获取外呼客户级别列表接口.
     */
    public function getClassification(): array
    {
        $resp = HttpClient::get($this->app->url('/api/v1/autoCallTasks/classification'), []);
        $decoded = json_decode($resp['body'], true);

        if ($decoded['code'] != 200) {
            throw new RuntimeException($decoded['message']);
        }
        return $decoded;
    }

    /**
     * hangup事件回调
     *
     * @param $fun
     *
     * @return void
     */
    public function webHookByHangup($fun)
    {
        if (!is_callable($fun)) {
            throw new RuntimeException('The callback is not callable');
        }
        $parameters = request()->post();
        $parameters = json_decode($parameters, true);

        $this->app->webHookAuth($parameters);

        if (!in_array('hangup', $parameters['events'])) {
            return;
        }
        //调用回调
        $fun(json_decode($parameters['data'], true));
    }

    /**
     * outboundTaskStatus 事件回调
     *
     * @param $fun
     *
     * @return void
     */
    public function webHookByOutboundTaskStatus($fun)
    {
        if (!is_callable($fun)) {
            throw new RuntimeException('The callback is not callable');
        }
        $parameters = request()->post();
        $parameters = json_decode($parameters, true);

        $this->app->webHookAuth($parameters);

        if (!in_array('outboundTaskStatus', $parameters['events'])) {
            return;
        }

        //调用回调
        $fun(json_decode($parameters['data'], true));
    }

}
