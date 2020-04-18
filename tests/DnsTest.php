<?php

namespace Gemz\Dns\Tests;

use Gemz\Dns\Dns;
use Gemz\Dns\Exceptions\InvalidArgument;
use PHPUnit\Framework\TestCase;

class DnsTest extends TestCase
{
    /** @var string */
    protected $domain = 'gemz.io';

    /** @var Dns */
    protected $dns;

    public function setUp(): void
    {
        $this->dns = new Dns($this->domain);
    }

    public function test_it_throws_exception_if_empty_string_is_passed()
    {
        $this->expectException(InvalidArgument::class);

        Dns::for('')->records();
    }

    public function test_it_throws_exception_when_not_allowed_type_is_passed()
    {
        $this->expectException(InvalidArgument::class);

        $this->dns->records('abc');
    }

    public function test_can_fetch_allowed_types()
    {
        $types = $this->dns->allowedRecordTypes();

        $this->assertTrue(count($types) > 5);
    }

    public function test_can_use_default_nameserver()
    {
        $nameserver = $this->dns->getNameserver();

        $this->assertSame('8.8.8.8', $nameserver);
    }

    public function test_can_use_nameserver()
    {
        $nameserver = $this->dns->useNameserver('test.example.org')->getNameserver();

        $this->assertSame('test.example.org', $nameserver);
    }

    public function test_can_sanitize_domain()
    {
        $dns = new Dns('https://example.org');

        $this->assertTrue($dns->getDomain() == 'example.org');
    }

    public function test_can_fetch_single_record_type()
    {
        $records = $this->dns->records('A');

        $this->assertArrayHasKey('A', $records);
    }

    public function test_can_fetch_single_record_type_as_lowercase()
    {
        $records = $this->dns->records('mx');

        $this->assertArrayHasKey('MX', $records);
    }

    public function test_can_fetch_multiple_record_types()
    {
        $records = $this->dns->records('MX', 'A');

        $this->assertArrayHasKey('MX', $records);
        $this->assertArrayHasKey('A', $records);
    }

    public function test_can_fetch_multiple_record_types_as_array()
    {
        $records = $this->dns->records(['MX', 'A']);

        $this->assertArrayHasKey('MX', $records);
        $this->assertArrayHasKey('A', $records);
    }

    public function test_can_fetch_all_records()
    {
        $records = $this->dns->records();
        $types = $this->dns->allowedRecordTypes();

        foreach ($types as $type) {
            $this->assertArrayHasKey($type, $records);
        }
    }
}
