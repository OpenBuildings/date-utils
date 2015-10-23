Date Utils
==========

[![Build Status](https://travis-ci.org/clippings/date-utils.svg?branch=master)](https://travis-ci.org/clippings/date-utils)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/clippings/date-utils/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/clippings/date-utils/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/clippings/date-utils/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/clippings/date-utils/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/clippings/date-utils/v/stable)](https://packagist.org/packages/clippings/date-utils)

Utility for days and date spans

Installation
------------

Install via composer

```
composer require clippings/date-utils
```

Usage
-----

```php
$span = new DaysSpan(new Days(20), new Days(40));
$start = new DateTime('today');
$dates = $span->toDateTimeSpan($start);

echo $dates->humanize();

// For week days
$span = new WeekDaysSpan(new WeekDays(20), new WeekDays(40));
$start = new DateTime('today');
$dates = $span->toDateTimeSpan($start);

// For business with support of lists of holidays

$holidays = new Holidays([
    new DateTime('<Holiday 1>'),
    new DateTime('<Holiday 2>'),
]);

$span = new BusinessDaysSpan(new BusinessDays(20, $holidays), new BusinessDays(40, $holidays));
$start = new DateTime('today');
$dates = $span->toDateTimeSpan($start);

```

License
-------

Copyright (c) 2015, Clippings Ltd. Developed by Ivan Kerin

Under BSD-3-Clause license, read LICENSE file.
