# udesk
## 安装
```composer require trigold/udesk ```
## 配置
```php artisan vendor:publish --provider="Trigold\\Udesk\\UdeskServiceProvider"```

# CRM 后台
## 使用
### 推送 号码数据
#### laravel Facades
```\Trigold\Udesk\Laravel\Facades\Crm::robot()->callTasksSyncNumber(任务id, 类型, 数据);```
#### 其他环境
```(new \Trigold\Udesk\App\Crm\Crm(EMAIL,SECRET_KEY))->callTasksSyncNumber(任务id, 类型, 数据);```

# CCPS 后台
## 使用
### 启动任务
#### laravel Facades
```\Trigold\Udesk\Laravel\Facades\Ccps::robot()->executing(任务id);```
#### 其他环境
```(new Ccps(EMAIL,APPID,SECRET))->robot()->executing(任务id);```

### 具体可查看
```src/App/Crm/Crm.php```
```src/App/Ccps/Ccps.php```
