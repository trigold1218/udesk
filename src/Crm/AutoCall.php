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
     */
    public function getTasks(int $pageNum = 1, int $pageSize = 20, string $name = null, int $status = null): array
    {
        $parameters = compact('pageNum', 'pageSize');

        if ($name) {
            $parameters['name'] = $name;
        }
        if ($status) {
            $parameters['status'] = $status;
        }

        $resp = HttpClient::get($this->app->url('/api/v1/autoCallTasks/auto'), $parameters);
        $decoded = json_decode($resp['body'], true);

        if ($decoded['code'] != 200) {
            throw new RuntimeException($decoded['message']);
        }
        return [
            'paging' => $decoded['paging'] ?? [],
            'data' => $decoded['data'] ?? [],
        ];
    }
}
