# cinling/ext-lib

![Packagist license](https://img.shields.io/github/license/cinling/php-ext-lib)
![Packagist version](https://img.shields.io/packagist/v/cinling/ext-lib)
![GitHub last commit](https://img.shields.io/github/last-commit/cinling/php-ext-lib)

# Install

```
composer require "cinling/ext-lib"
```

# Document

 - [Service](#Service)
   - [FileCacheService](#FileCacheService)
   - [LogService](#LogService)
 - [Util](#Util)
 - Application Object (ao)...
 - Enums...
    

<hr />

## Service

 - Encapsulation of a function
 - Provides configurable parameters

<hr />

### FileCacheService

 - Save data to file

##### Config

| name | type | note | default |
| --- | --- | --- | --- |
| path | string | Cache file save path | ./runtime/cin-cache |
| pathDeeps | int | Path depth | 2 |
| pathUnitLen | int | The number of characters in a single directory | 2 |

##### Example

Set cache

```php
use cin\extLib\services\FileCacheService;

FileCacheService::getIns()->set("CacheKeyCin", "cin");
```

Get cache

```php
use cin\extLib\services\FileCacheService;

$srv = FileCacheService::getIns();
$srv->set("CacheKeyCin", "cin");
$value = FileCacheService::getIns()->get("CacheKeyCin");
echo $value; // output: cin
```

Delete cache

```php
use cin\extLib\services\FileCacheService;

$srv = FileCacheService::getIns();
$srv->set("CacheKeyCin", "cin");
$srv->del("CacheKeyCin");
$value = $srv->get("CacheKeyCin");
echo $value; // output: null
```

Set cache with expiration time

```php
use cin\extLib\services\FileCacheService;

FileCacheService::getIns()->set("CacheKeyCin", "cin", 3600); // expire after 3600s
```

<hr />

### LogService

 - Output the log and save it in the log file

##### Config

| name | type | note | default |
| --- | --- | --- | --- |
| path | string | Log file save path | ./runtime/cin-log |
| fileMaxSize | string | Log file max bytes | 2MB |

##### Example

```php
use cin\extLib\services\LogService;

LogService::getIns()->info("Content...", "Title");
```

output in `runtime/cin-log/cin.log`:
> [2021-01-18 14:54:31 INFO Title] Content...

<hr />

### Util

 - Provides encapsulation of static methods
 - It can be inserted by `trait`

<hr />