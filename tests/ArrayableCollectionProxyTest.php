<?php

namespace Splitstack\EnumFriendly\Tests;

use Orchestra\Testbench\TestCase;
use Illuminate\Support\Collection;
use Splitstack\EnumFriendly\Support\ArrayableCollectionProxy;

class ArrayableCollectionProxyTest extends TestCase
{
    private function proxy(?array $data = null): ArrayableCollectionProxy
    {
        return new ArrayableCollectionProxy(collect($data ?? [
            ['name' => 'Active', 'value' => 'active'],
            ['name' => 'Inactive', 'value' => 'inactive'],
        ]));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_counts_items(): void
    {
        $this->assertCount(2, $this->proxy());
        $this->assertCount(0, $this->proxy([]));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_is_iterable(): void
    {
        $results = [];
        foreach ($this->proxy() as $item) {
            $results[] = $item;
        }
        $this->assertCount(2, $results);
        $this->assertEquals('Active', $results[0]['name']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_supports_array_access_read(): void
    {
        $proxy = $this->proxy();
        $this->assertTrue(isset($proxy[0]));
        $this->assertEquals(['name' => 'Active', 'value' => 'active'], $proxy[0]);
        $this->assertFalse(isset($proxy[99]));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_throws_on_array_set(): void
    {
        $this->expectException(\BadMethodCallException::class);
        $proxy = $this->proxy();
        $proxy[0] = ['name' => 'New', 'value' => 'new'];
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_throws_on_array_unset(): void
    {
        $this->expectException(\BadMethodCallException::class);
        $proxy = $this->proxy();
        unset($proxy[0]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_converts_to_array(): void
    {
        $this->assertEquals([
            ['name' => 'Active', 'value' => 'active'],
            ['name' => 'Inactive', 'value' => 'inactive'],
        ], $this->proxy()->toArray());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_serializes_to_json(): void
    {
        $json = $this->proxy()->toJson();
        $this->assertJson($json);
        $this->assertStringContainsString('active', $json);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_casts_to_string_as_json(): void
    {
        $proxy = $this->proxy();
        $this->assertJson((string) $proxy);
        $this->assertEquals($proxy->toJson(), (string) $proxy);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_implements_json_serializable(): void
    {
        $encoded = json_encode($this->proxy());
        $this->assertIsString($encoded);
        $this->assertJson($encoded);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_implements_stringable(): void
    {
        $this->assertInstanceOf(\Stringable::class, $this->proxy());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_returns_underlying_collection(): void
    {
        $collection = $this->proxy()->collect();
        $this->assertInstanceOf(Collection::class, $collection);
        $this->assertCount(2, $collection);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_proxies_collection_methods(): void
    {
        $proxy = $this->proxy();

        $first = $proxy->first();
        $this->assertEquals(['name' => 'Active', 'value' => 'active'], $first);

        $values = $proxy->pluck('value')->toArray();
        $this->assertEquals(['active', 'inactive'], $values);

        $filtered = $proxy->filter(fn($item) => $item['value'] === 'active');
        $this->assertCount(1, $filtered);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_throws_on_unknown_method(): void
    {
        $this->expectException(\BadMethodCallException::class);
        $this->proxy()->nonExistentMethod();
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_round_trips_through_serialize(): void
    {
        $proxy = $this->proxy();
        $serialized = serialize($proxy);
        $restored = unserialize($serialized);

        $this->assertInstanceOf(ArrayableCollectionProxy::class, $restored);
        $this->assertEquals($proxy->toArray(), $restored->toArray());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_handles_empty_collection(): void
    {
        $proxy = $this->proxy([]);
        $this->assertCount(0, $proxy);
        $this->assertEquals([], $proxy->toArray());
        $this->assertEquals('[]', (string) $proxy);
        $this->assertNull($proxy->first());
    }
}
