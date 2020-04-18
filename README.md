# Get DNS records

[![Latest Version on Packagist](https://img.shields.io/packagist/v/gemz/dns.svg?style=flat-square)](https://packagist.org/packages/gemz/dns)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/gemzio/dns/run-tests?label=tests)](https://github.com/gemzio/dns/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Quality Score](https://img.shields.io/scrutinizer/g/gemzio/dns.svg?style=flat-square)](https://scrutinizer-ci.com/g/gemzio/dns)
[![Total Downloads](https://img.shields.io/packagist/dt/gemz/dns.svg?style=flat-square)](https://packagist.org/packages/gemz/dns)

Retrieve DNS records for a given domain. Under the hood the package uses [https://github.com/reactphp/reactphp](https://github.com/reactphp/reactphp) 
for concurrent dns queries. 

## Installation

You can install the package via composer:

```bash
composer require gemz/dns
```

## Usage

```php
use Gemz\Dns\Dns;

// initialization
$dns = new Dns('gemz.io');
$dns = Dns::for('gemz.io');

// supported record types
// returns ["A", "CAA", "CNAME", "SOA", "TXT", "MX", "AAAA", "SRV", "NS", "PTR", "SSHFP"]
$dns = Dns::for('gemz.io')->allowedRecordTypes();

// get results for all record types
$dns = Dns::for('gemz.io')->records();

 // get result for specific record(s)
$dns = Dns::for('gemz.io')->records(['A', 'CNAME']);
$dns = Dns::for('gemz.io')->records('A', 'MX', 'TXT');

// using a nameserver
$dns = Dns::for('gemz.io')->useNameServer('example.gemz.io')->records();

// sanitizing domain
$domain = Dns::for('https://gemz.io')->getDomain(); // gemz.io

// record type results
$dns = Dns::for('gemz.io')->records('A', 'NS');
// depending on the record type "data" will be a string or an array with different keys
// result is an array in form of:
[
  "A" => [
    ["ttl" => 21599, "data" => "<ip>"]
  ],
  "NS" => [
    ["ttl" => 21599, "data" => "<nameserver1>"],
    ["ttl" => 21599, "data" => "<nameserver2>"],
  ],
  "MX" => [
    ["ttl" => 21599, "data" => ["priority" => 10, "target" => "<mx1>"]],
    ["ttl" => 21599, "data" => ["priority" => 20, "target" => "<mx2>"]],
  ]
];
```

### Testing

``` bash
composer test
composer test-coverage
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email stefan@sriehl.com instead of using the issue tracker.

## Credits

- [Stefan Riehl](https://github.com/stefanriehl)
- [All Contributors](../../contributors)

## Support us

Gemz.io is maintained by [Stefan Riehl](https://github.com/stefanriehl). You'll find all open source
projects on [Gemz.io github](https://github.com/gemzio).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
