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
    public function getTasks(int $pageNum = 1, int $pageSize = 20, string $name = '', int $status = 1): array
    {
        $parameters = compact('pageNum', 'pageSize', 'name', 'status');

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
