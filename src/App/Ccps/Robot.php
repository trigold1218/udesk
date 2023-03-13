<?php

namespace Trigold\Udesk\App\Ccps;

use Trigold\Udesk\Traits\Response;

class Robot
{
    use Response;

    protected Ccps $app;

    public function __construct(Ccps $ccps)
    {
        $this->app = $ccps;
    }

    /**
     * 创建外呼任务接口
     *
     * @param  string  $name
     * @param  int     $callTemplateId
     * @param  int     $robotDefId
     * @param  int     $spnumberType
     * @param  int     $spnumberValue
     * @param  int     $startMode
     * @param  int     $workTimeId
     * @param  int     $priority
     * @param  int     $concurrentLimit
     * @param  string  $remark
     * @param  string  $startTime
     * @param  int     $ivrMode
     * @param  int     $callType
     * @param  array   $controlOptionList
     * @param  array   $dialParam
     * @param  array   $redialSceneList
     * @param  array   $taskContactBatchRelList
     *
     * @return array
     * @see https://www.udesk.cn/doc/ccpsrobot/chapter2-24/#_6
     *
     */
    public function create(
        string $name,
        int $callTemplateId,
        int $robotDefId,
        int $spnumberType,
        int $spnumberValue,
        int $startMode,
        int $workTimeId,
        int $priority,
        int $concurrentLimit,
        string $remark = '',
        string $startTime = '',
        int $ivrMode = 0,
        int $callType = 0,
        array $controlOptionList = [],
        array $dialParam = [],
        array $redialSceneList = [],
        array $taskContactBatchRelList = []
    ): array {

        $parameters = compact('name', 'remark', 'callTemplateId', 'robotDefId', 'spnumberType', 'spnumberValue',
            'startMode', 'startTime', 'workTimeId', 'priority', 'ivrMode', 'callType',
            'concurrentLimit');

        if ($controlOptionList) {
            $parameters['controlOptionList'] = $controlOptionList;
        }

        if ($dialParam) {
            $parameters['dialParam'] = $dialParam;
        }

        if ($redialSceneList) {
            $parameters['redialSceneList'] = $redialSceneList;
        }

        if ($taskContactBatchRelList) {
            $parameters['taskContactBatchRelList'] = $taskContactBatchRelList;
        }

        return $this->response($this->app->client->post($this->app->url('/api/v1/ads/external/callTasks/ai'),
            $parameters));
    }


    /**
     * 创建外呼任务接口（简版）.
     *
     * @param  string  $name
     * @param  int     $callTemplateId
     * @param  int     $priority
     * @param  int     $startMode
     * @param  string  $startTime
     * @param  string  $startDate
     * @param  string  $endDate
     * @param  string  $startTimePoint
     * @param  string  $expireTime
     * @param  int     $dealType
     * @param  string  $remark
     *
     *
     * @return array
     * @see https://www.udesk.cn/doc/ccpsrobot/chapter2-24/#_46
     */
    public function createSimply(
        string $name,
        int $callTemplateId,
        int $priority,
        int $startMode,
        string $startTime = '',
        string $startDate = '',
        string $endDate = '',
        string $startTimePoint = '',
        string $expireTime = '',
        int $dealType = 0,
        string $remark = ''
    ): array {
        $parameters = compact('name', 'callTemplateId', 'priority', 'startMode');

        if ($startTime) {
            $parameters['startTime'] = $startTime;
        }

        if ($startDate) {
            $parameters['startDate'] = $startDate;
        }

        if ($endDate) {
            $parameters['endDate'] = $endDate;
        }

        if ($startTimePoint) {
            $parameters['startTimePoint'] = $startTimePoint;
        }

        if ($expireTime) {
            $parameters['expireTime'] = $expireTime;
        }

        if ($dealType) {
            $parameters['dealType'] = $dealType;
        }

        if ($remark) {
            $parameters['remark'] = $remark;
        }

        return $this->response($this->app->client->post($this->app->url('/api/v1/ads/callTasks/simply'),
            $parameters));

    }

    /**
     * 更新外呼任务接口
     *
     * @param  int     $id
     * @param  string  $name
     * @param  int     $callTemplateId
     * @param  int     $robotDefId
     * @param  int     $spnumberType
     * @param  int     $spnumberValue
     * @param  int     $startMode
     * @param  int     $workTimeId
     * @param  int     $priority
     * @param  int     $concurrentLimit
     * @param  string  $remark
     * @param  string  $startTime
     * @param  int     $ivrMode
     * @param  int     $callType
     * @param  array   $controlOptionList
     * @param  array   $dialParam
     * @param  array   $redialSceneList
     * @param  array   $taskContactBatchRelList
     *
     * @return array
     * @see https://www.udesk.cn/doc/ccpsrobot/chapter2-24/#_12
     *
     */
    public function update(
        int $id,
        string $name,
        int $callTemplateId,
        int $robotDefId,
        int $spnumberType,
        int $spnumberValue,
        int $startMode,
        int $workTimeId,
        int $priority,
        int $concurrentLimit,
        string $remark = '',
        string $startTime = '',
        int $ivrMode = 0,
        int $callType = 0,
        array $controlOptionList = [],
        array $dialParam = [],
        array $redialSceneList = [],
        array $taskContactBatchRelList = []
    ): array {

        $parameters = compact('name', 'remark', 'callTemplateId', 'robotDefId', 'spnumberType', 'spnumberValue',
            'startMode', 'startTime', 'workTimeId', 'priority', 'ivrMode', 'callType',
            'concurrentLimit');

        if ($controlOptionList) {
            $parameters['controlOptionList'] = $controlOptionList;
        }

        if ($dialParam) {
            $parameters['dialParam'] = $dialParam;
        }

        if ($redialSceneList) {
            $parameters['redialSceneList'] = $redialSceneList;
        }

        if ($taskContactBatchRelList) {
            $parameters['taskContactBatchRelList'] = $taskContactBatchRelList;
        }

        return $this->response($this->app->client->put($this->app->url('/api/v1/ads/external/callTasks/'.$id),
            $parameters));
    }

    /**
     * 启动外呼任务.
     *
     * @param  int  $id
     *
     * @return array
     * @see https://www.udesk.cn/doc/ccpsrobot/chapter2-24/#_18
     */
    public function executing(int $id): array
    {
        return $this->response($this->app->client->put($this->app->url('/api/v1/ads/external/callTasks/status/'.$id.'/executing')));
    }

    /**
     * 暂停外呼任务.
     *
     * @param $id
     *
     * @return array
     * @see https://www.udesk.cn/doc/ccpsrobot/chapter2-24/#_24
     */
    public function pause($id): array
    {
        return $this->response($this->app->client->put($this->app->url('/api/v1/ads/external/callTasks/status/'.$id.'/pause')));
    }

    /**
     * 停止外呼任务.
     *
     * @param $id
     *
     * @return array
     * @see https://www.udesk.cn/doc/ccpsrobot/chapter2-24/#_30
     */
    public function stop($id): array
    {
        return $this->response($this->app->client->put($this->app->url('/api/v1/ads/external/callTasks/status/'.$id.'/stop')));
    }

    /**
     * 创建AI默认联系人列表接口.
     *
     * @param  int     $callTaskId
     * @param  string  $name
     * @param  string  $remark
     * @param  string  $focus
     *
     * @return array
     * @see https://www.udesk.cn/doc/ccpsrobot/chapter2-24/#ai
     */
    public function createDefaultContact(
        int $callTaskId,
        string $name,
        string $remark = '',
        string $focus = ''
    ): array {
        $parameters = compact('callTaskId', 'name', 'remark', 'focus');

        return $this->response($this->app->client->post($this->app->url('/api/v1/ads/external/contactBatchs/defaultContact'),
            $parameters));
    }

    /**
     * 查询外呼任务联系单列表接口(无文档说明).
     *
     * @param  int     $callTaskId
     * @param  int     $pageNum
     * @param  int     $pageSize
     * @param  string  $name
     *
     * @return array
     */
    public function taskContactBatchSearch(
        int $callTaskId,
        int $pageNum = 1,
        int $pageSize = 20,
        string $name = ''
    ): array {
        $parameters = compact('callTaskId', 'pageNum', 'pageSize', 'name');
        return $this->response($this->app->client->post($this->app->url('/api/v1/ads/taskContactBatchRels/search'),
            $parameters));
    }

    /**
     * 查询外呼任务联系单下的联系人接口(无文档说明).
     *
     * @param  int          $callTaskId
     * @param  int          $taskContactBatchRelId
     * @param  int          $pageNum
     * @param  int          $pageSize
     * @param  int|null     $callResult
     * @param  string       $mobile
     * @param  string|null  $lastCallTimeMin
     * @param  string|null  $lastCallTimeMax
     * @param  bool         $desensitization
     *
     * @return array
     */
    public function taskContactDetailSearch(
        int $callTaskId,
        int $taskContactBatchRelId,
        int $pageNum = 1,
        int $pageSize = 20,
        int $callResult = null,
        string $mobile = '',
        string $lastCallTimeMin = null,
        string $lastCallTimeMax = null,
        bool $desensitization = false
    ): array {
        $parameters = compact('callTaskId', 'taskContactBatchRelId', 'pageNum', 'pageSize', 'callResult', 'mobile',
            'lastCallTimeMin', 'lastCallTimeMax', 'desensitization');
        return $this->response($this->app->client->post($this->app->url('/api/v1/ads/taskContactDetailRels/search'),
            $parameters));
    }

    /**
     * 导入联系人号码接口(单次上限50条).
     *
     * @param  int     $contactBatchId
     * @param  int     $dealType
     * @param  int     $encryptionFlag
     * @param  int     $algorithmType
     * @param  string  $secretKey
     * @param  array   $encryptionRange
     * @param  array   $numberList
     *
     * @return array
     * @see https://www.udesk.cn/doc/ccpsrobot/chapter2-24/#50
     */
    public function contactSyncNumber(
        int $contactBatchId,
        int $encryptionFlag,
        array $numberList,
        int $dealType = 0,
        int $algorithmType = 0,
        string $secretKey = '',
        array $encryptionRange = []
    ): array {
        $parameters = compact('contactBatchId', 'encryptionFlag', 'numberList');

        if ($dealType) {
            $parameters['dealType'] = $dealType;
        }

        if ($algorithmType) {
            $parameters['algorithmType'] = $algorithmType;
        }

        if ($secretKey) {
            $parameters['secretKey'] = $secretKey;
        }

        if ($encryptionRange) {
            $parameters['encryptionRange'] = $encryptionRange;
        }

        return $this->response($this->app->client->post($this->app->url('/api/v1/ads/external/contactBatchs/syncNumber'),
            $parameters));

    }

    /**
     * 查询外呼任务列表(无文档说明).
     *
     * @param  int     $pageNum
     * @param  int     $pageSize
     * @param  int     $status  1:已暂停 2:运行中 3:已停止 4:暂停中 5:停止中 6:已过期
     * @param  string  $name
     * @param  string  $startTime
     * @param  string  $endTime
     *
     * @return array
     * @see null
     */
    public function search(
        int $pageNum = 1,
        int $pageSize = 20,
        int $status = 0,
        string $name = '',
        string $startTime = '',
        string $endTime = ''
    ): array {
        $parameters = compact('pageNum', 'pageSize', 'status', 'name', 'endTime', 'startTime');
        return $this->response($this->app->client->post($this->app->url('/api/v1/ads/callTasks/search'), $parameters));
    }


    /**
     * 查询外呼任务列表（基础版）.
     *
     * @param  int     $pageNum
     * @param  int     $pageSize
     * @param  string  $name
     * @param  int     $status  1:已暂停 2:运行中 3:已停止 4:暂停中 5:停止中 6:已过期
     * @param  int     $category
     *
     * @return array
     * @see https://www.udesk.cn/doc/ccpsrobot/chapter2-24/#_52
     */
    public function searchBasic(
        int $pageNum = 1,
        int $pageSize = 20,
        string $name = '',
        int $status = 0,
        int $category = 0
    ): array {
        $parameters = compact('pageNum', 'pageSize');

        if ($name) {
            $parameters['name'] = $name;
        }

        if ($status) {
            $parameters['status'] = $status;
        }

        if ($category) {
            $parameters['category'] = $category;
        }

        return $this->response($this->app->client->post($this->app->url('/api/v1/ads/external/callTasks/basicSearch'),
            $parameters));
    }

    /**
     * 外呼任务状态查询.
     *
     * @param $id
     *
     * @return array
     */
    public function status($id): array
    {
        return $this->response(
            $this->app->client->get(
                $this->app->url(
                    sprintf('/api/v1/ads/external/callTasks/%d/status', $id)
                )
            )
        );
    }

    /**
     * excel导出外呼任务列表(无文档说明).
     *
     * @param  int     $status
     * @param  string  $name
     * @param  string  $startTime
     * @param  string  $endTime
     * @param  string  $language
     *
     * @return array
     */
    public function export(
        int $status = 0,
        string $name = '',
        string $startTime = '',
        string $endTime = '',
        string $language = 'ZH-CN'
    ): array {

        $parameters = compact('language');

        if ($status) {
            $parameters['status'] = $status;
        }

        if ($name) {
            $parameters['name'] = $name;
        }

        if ($startTime) {
            $parameters['startTime'] = $startTime;
        }

        if ($endTime) {
            $parameters['endTime'] = $endTime;
        }

        return $this->response($this->app->client->post($this->app->url('/api/v1/ads/callTasks/excel/generate'),
            $parameters));

    }

    /**
     * 外呼任务告警设置(无文档说明).
     *
     * @param  int     $callTaskId             任务id
     * @param  int     $ignoreAlarmCount       当任务中已执行号码数量超过该值时，触发报警
     * @param  int     $answeredRate           呼出接通率
     * @param  int     $answeredRateFlag       呼出接通率启用标识 0:关闭 1:启用
     * @param  int     $avgDuration            平均通话时长
     * @param  int     $avgDurationFlag        平均通话时长启用标识 0:关闭 1:启用
     * @param  int     $transferAgentRate      转人工率
     * @param  int     $transferAgentRateFlag  转人工率启用标识 0:关闭 1:启用
     * @param  int     $waitDuration           等待时长
     * @param  int     $waitDurationFlag       等待时长启用标识 0:关闭 1:启用
     * @param  string  $operatorCreateName     创建人 不确定的值
     *
     * @return array
     */
    public function alarm(
        int $callTaskId,
        int $ignoreAlarmCount,
        int $answeredRate,
        int $answeredRateFlag,
        int $avgDuration,
        int $avgDurationFlag,
        int $transferAgentRate,
        int $transferAgentRateFlag,
        int $waitDuration,
        int $waitDurationFlag,
        string $operatorCreateName = ''
    ): array {
        $parameters = compact('callTaskId', 'answeredRate', 'answeredRateFlag', 'avgDuration', 'avgDurationFlag',
            'ignoreAlarmCount', 'transferAgentRate', 'transferAgentRateFlag', 'waitDuration', 'waitDurationFlag');

        if ($operatorCreateName) {
            $parameters['operatorCreateName'] = $operatorCreateName;
        }

        return $this->response($this->app->client->put($this->app->url('/api/v1/ads/alarm'), $parameters));
    }

    /**
     * 查询联系人列表(无文档说明).
     *
     * @param  int     $pageNum
     * @param  int     $pageSize
     * @param  string  $focus
     * @param  string  $name
     *
     * @return array
     */
    public function contactBatchSearch(
        int $pageNum = 1,
        int $pageSize = 20,
        string $focus = '',
        string $name = ''
    ): array {

        $parameters = compact('pageNum', 'pageSize');

        if ($focus) {
            $parameters['focus'] = $focus;
        }

        if ($name) {
            $parameters['name'] = $name;
        }

        return $this->response($this->app->client->post($this->app->url('/api/v1/ads/contactBatchs/search'),
            $parameters));
    }
}
