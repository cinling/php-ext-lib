# cinling/ext-lib

![Packagist license](https://img.shields.io/github/license/cinling/php-ext-lib)
![Packagist version](https://img.shields.io/packagist/v/cinling/ext-lib)
![GitHub last commit](https://img.shields.io/github/last-commit/cinling/php-ext-lib)

# Install

```
composer require "cinling/ext-lib"
```

# Document

 - Service
   - [LogService](#LogService)
    


<hr />

### LogService

Output the log and save it in the log file

###### Config

| name | type | note | default |
| --- | --- | --- | --- |
| path | string | Log file save path | ./runtime/cin-log |
| fileMaxSize | string | Log file max bytes | 2MB |

###### Example

```php
use cin\extLib\services\LogService;

LogService::getIns()->info("Content...", "Title");
```

output in `runtime/cin-log/cin.log`:
> [2021-01-18 14:54:31 INFO Title] Content...

<hr />