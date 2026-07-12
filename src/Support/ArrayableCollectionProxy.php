<?php

namespace Splitstack\EnumFriendly\Support;

use Illuminate\Support\Collection;
use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use JsonSerializable;
use Stringable;

/**
 * @template TKey of array-key
 * @template TValue
 * @implements ArrayAccess<TKey, TValue>
 * @implements IteratorAggregate<TKey, TValue>
 */
class ArrayableCollectionProxy implements ArrayAccess, Countable, IteratorAggregate, JsonSerializable, Stringable
{
    /** @var Collection<TKey, TValue> */
    protected Collection $collection;

    /** @param Collection<TKey, TValue> $collection */
    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    public function offsetExists(mixed $offset): bool
    {
        return $this->collection->has($offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->collection->get($offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new \BadMethodCallException('Cannot set value on a read-only collection proxy.');
    }

    public function offsetUnset(mixed $offset): void
    {
        throw new \BadMethodCallException('Cannot unset value on a read-only collection proxy.');
    }

    public function count(): int
    {
        return $this->collection->count();
    }

    /** @return ArrayIterator<TKey, TValue> */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->collection->all());
    }

    public function jsonSerialize(): mixed
    {
        return $this->collection->all();
    }

    /** @return array<TKey, TValue> */
    public function toArray(): array
    {
        return $this->collection->toArray();
    }

    public function toJson(int $options = 0): string
    {
        return $this->collection->toJson($options);
    }

    /** @return Collection<TKey, TValue> */
    public function collect(): Collection
    {
        return $this->collection;
    }

    public function __toString(): string
    {
        return $this->collection->toJson();
    }

    /** @return array<TKey, TValue> */
    public function __serialize(): array
    {
        return $this->collection->all();
    }

    /** @param array<TKey, TValue> $data */
    public function __unserialize(array $data): void
    {
        $this->collection = collect($data);
    }

    public function __call(string $method, array $parameters): mixed
    {
        if (method_exists($this->collection, $method)) {
            return $this->collection->$method(...$parameters);
        }

        throw new \BadMethodCallException("Method {$method} does not exist on the collection.");
    }
}
