# udesk
## 安装
```composer require trigold/udesk ```
## 配置
```php artisan vendor:publish --provider="Trigold\\Udesk\\UdeskServiceProvider"```
## 使用
```Crm::robot()->callTasksSyncNumber(任务id, 类型, 数据);```
### 具体可查看
```src/Crm/App.php```
```src/Crm/Robot.php```
