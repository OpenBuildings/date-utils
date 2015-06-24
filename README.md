Date Utils
==========

[![Build Status](https://travis-ci.org/{%repository_name%}.png?branch=master)](https://travis-ci.org/clippings/date-utils)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/{%repository_name%}/badges/quality-score.png)](https://scrutinizer-ci.com/g/clippings/date-utils/)
[![Code Coverage](https://scrutinizer-ci.com/g/{%repository_name%}/badges/coverage.png)](https://scrutinizer-ci.com/g/clippings/date-utils/)
[![Latest Stable Version](https://poser.pugx.org/{%repository_name%}/v/stable.png)](https://packagist.org/packages/clippings/date-utils)

Utility for days and date spans

Instalation
-----------

Install via composer

```
composer require clippings/date-utils
```

Usage
-----

```
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
