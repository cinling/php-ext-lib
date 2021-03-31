# cinling/ext-lib

![Packagist license](https://img.shields.io/github/license/cinling/php-ext-lib)
![Packagist version](https://img.shields.io/packagist/v/cinling/ext-lib)
![GitHub last commit](https://img.shields.io/github/last-commit/cinling/php-ext-lib)
![Php version](https://img.shields.io/packagist/php-v/cinling/ext-lib)

![File size](https://img.shields.io/github/languages/code-size/cinling/php-ext-lib)

# 安装

使用 composer 进行安装

```
composer require "cinling/ext-lib"
```

# 主要内容文档

 - [Enum](#) 枚举
 - [Service](#Service) 服务
   - [CronService](#CronService) 定时任务管理服务
   - [FileCacheService](#FileCacheService) 文件缓存服务
   - [FtpClientService](#) FTP客户端服务
   - [LogService](#LogService) 日志服务
   - [SqbService](#) 收钱吧服务
   - [ValidFactoryService](#) 验证方法工厂服务
   - [WechatPayService](#) 微信支付服务（未完成）
   - [WechatService](#) 微信公众号/网页服务
 - [Util](#Util) 工具
   - [ArrayUtil](#ArrayUtil) 数组工具
   - [ConsoleUtil](#) 控制台工具
   - [CronParseUtil](#) 定时任务时间计算工具
   - [DevelUtil](#) 开发工具
   - [EncryptUtil](#) 加密工具
   - [EnvUtil](#) 环境工具
   - [ExcelUtil](#) Excel工具
   - [FileUtil](#) 文件工具
   - [GeoUtil](#) 地理经纬度工具
   - [HttpUtil](#) Http请求工具
   - [JsonUtil](#) JSON数据处理工具
   - [StringUtil](#) 字符串工具
   - [TimeUtil](#) 时间工具
   - [UtlUtil](#) url路径工具
   - [ValueUtil](#) 数值处理工具
   - [XmlUtil](#) Xml数据处理工具
 - [Value Object(vo)](#) 数据对象  
    

<hr />

## Service

 - 提供一些服务性的功能

<hr />

### CronService

 - 定时任务服务
 - 目前进支持 命令行 形式的定时任务。计划于 v3.2.0 添加可触发执行指定方法

#### 配置

##### 参数

| 参数 | 类型 | 说明 |
| --- | --- | --- |
| ~~store~~ | ICronStore | 存取应用对象。不推荐直接设置，v3.0.0 后将设置为 protected |
| taskVoList | TaskVo[] | 任务对象 |
| recordLimit | int | 任务运行记录最大存储条数（文件缓存不建议太多）。默认：10000，设置为 -1 代表不限制 |

##### 方法

| 方法 | 说明 |
| --- | --- |
| getStore(): ICronStore | 获取存取应用实例 |
| setStore(ICronStore) | 设置存取应用实例 |
| setTaskVoList(array $taskVoList) | 设置任务列表 |

##### 案例

```injectablephp
use cin\extLib\services\CronService;
use cin\extLib\traits\SingleTrait;

/**
 * 定时任务入口（单例）
 */
class CronEnter {
    use SingleTrait;

    protected function __construct() {
        CronService::getIns();
    }
}
```

<hr />

### FileCacheService

 - 文件缓存服务。将数据缓存到文件中

##### 配置

| name | 数据类型 | 说明 | 默认值 |
| --- | --- | --- | --- |
| path | string | 缓存文件路径 | ./runtime/cin-cache |
| pathDeeps | int | 缓存文件夹层次深度 | 2 |
| pathUnitLen | int | 单个目录中的字符数 | 2 |

##### Example

设置缓存 set

```php
use cin\extLib\services\FileCacheService;

FileCacheService::getIns()->set("CacheKeyCin", "cin");
```

获取缓存 get

```php
use cin\extLib\services\FileCacheService;

$srv = FileCacheService::getIns();
$srv->set("CacheKeyCin", "cin");
$value = FileCacheService::getIns()->get("CacheKeyCin");
echo $value; // output: cin
```

删除缓存 del

```php
use cin\extLib\services\FileCacheService;

$srv = FileCacheService::getIns();
$srv->set("CacheKeyCin", "cin");
$srv->del("CacheKeyCin");
$value = $srv->get("CacheKeyCin");
echo $value; // output: null
```

设置缓存有效期 

```php
use cin\extLib\services\FileCacheService;

FileCacheService::getIns()->set("CacheKeyCin", "cin", 3600); // 3600秒后失效
```

<hr />

### LogService

 - 日志服务。将日志输出到文件中

##### 配置

| name | 数据类型 | 说明 | 默认值 |
| --- | --- | --- | --- |
| path | string | 日志文件的输出路径 | ./runtime/cin-log |
| fileMaxSize | string | 单文件最大字节数 | 2MB |

##### 例子

```php
use cin\extLib\services\LogService;

LogService::getIns()->info("Content...", "Title");
```

output in `runtime/cin-log/cin.log`:
> [2021-01-18 14:54:31 INFO Title] Content...

<hr />

## Util

 - Provides encapsulation of static methods
 - It can be inserted by `trait`

<hr />

### ArrayUtil


##### toArray($attrs): array

Convert `$attrs` to an array。
`$attrs` can be an `array`, an `object`, a `BaseVo` derived class, or any collation of the above
 
