<?php

namespace Splitstack\EnumFriendly\Tests;

use Orchestra\Testbench\TestCase;
use Illuminate\Support\Collection;
use Splitstack\EnumFriendly\Tests\Enums\TestStatusStr;
use Splitstack\EnumFriendly\Tests\Enums\TestStatusInt;
use Splitstack\EnumFriendly\Tests\Enums\TestStatusUnbacked;

class EnumsTest extends TestCase
{
    /** @test */
    public function it_can_get_all_values()
    {
        // String backed enum
        $this->assertEquals(
            ['pending', 'in_progress', 'completed'],
            TestStatusStr::values()
        );

        // Int backed enum
        $this->assertEquals(
            [1, 2, 3],
            TestStatusInt::values()
        );

        // Unbacked enum
        $this->assertEquals(
            [
                'PENDING',
                'IN_PROGRESS',
                'COMPLETED'
            ],
            TestStatusUnbacked::values()
        );
    }

    /** @test */
    public function it_can_collect_values()
    {
        // String backed enum
        $strCollection = TestStatusStr::collect();
        $this->assertInstanceOf(Collection::class, $strCollection);
        $this->assertEquals(
            ['pending', 'in_progress', 'completed'],
            $strCollection->toArray()
        );

        // Int backed enum
        $intCollection = TestStatusInt::collect();
        $this->assertInstanceOf(Collection::class, $intCollection);
        $this->assertEquals(
            [1, 2, 3],
            $intCollection->toArray()
        );

        // Unbacked enum
        $plainCollection = TestStatusUnbacked::collect();
        $this->assertInstanceOf(Collection::class, $plainCollection);
        $this->assertEquals(
            ['PENDING', 'IN_PROGRESS', 'COMPLETED'],
            $plainCollection->toArray()
        );
    }

    /** @test */
    public function it_can_implode_values()
    {
        // String backed enum
        // $this->assertEquals('pending,in_progress,completed', TestStatusStr::implode());
        // $this->assertEquals('pending|in_progress|completed', TestStatusStr::implode('|'));

        // // Int backed enum
        // $this->assertEquals('1,2,3', TestStatusInt::implode());
        // $this->assertEquals('1|2|3', TestStatusInt::implode('|'));

        // Unbacked enum
        $this->assertEquals('PENDING,IN_PROGRESS,COMPLETED', TestStatusUnbacked::implode());
        $this->assertEquals('PENDING|IN_PROGRESS|COMPLETED', TestStatusUnbacked::implode('|'));
    }

    /** @test */
    public function it_can_convert_to_select_options()
    {
        // String backed enum
        $strOptions = TestStatusStr::toSelectOptions();
        $this->assertInstanceOf(Collection::class, $strOptions);
        $this->assertEquals([
            ['value' => 'pending', 'label' => 'Pending', 'name' => 'Pending'],
            ['value' => 'in_progress', 'label' => 'In Progress', 'name' => 'In Progress'],
            ['value' => 'completed', 'label' => 'Completed', 'name' => 'Completed']
        ], $strOptions->toArray());

        // Int backed enum
        $intOptions = TestStatusInt::toSelectOptions();
        $this->assertInstanceOf(Collection::class, $intOptions);
        $this->assertEquals([
            ['value' => 1, 'label' => 'Pending', 'name' => 'Pending'],
            ['value' => 2, 'label' => 'In Progress', 'name' => 'In Progress'],
            ['value' => 3, 'label' => 'Completed', 'name' => 'Completed']
        ], $intOptions->toArray());

        // Unbacked enum
        $plainOptions = TestStatusUnbacked::toSelectOptions();
        $this->assertInstanceOf(Collection::class, $plainOptions);
        $this->assertEquals([
            ['value' => 'PENDING', 'label' => 'Pending', 'name' => 'Pending'],
            ['value' => 'IN_PROGRESS', 'label' => 'In Progress', 'name' => 'In Progress'],
            ['value' => 'COMPLETED', 'label' => 'Completed', 'name' => 'Completed']
        ], $plainOptions->toArray());
    }

    /** @test */
    public function it_can_get_keys()
    {
        $expected = ['PENDING', 'IN_PROGRESS', 'COMPLETED'];

        // All enum types should return the same keys
        $this->assertEquals($expected, TestStatusStr::keys());
        $this->assertEquals($expected, TestStatusInt::keys());
        $this->assertEquals($expected, TestStatusUnbacked::keys());
    }

    /** @test */
    public function it_can_get_readable_values()
    {
        $expected = ['Pending', 'In Progress', 'Completed'];

        // All enum types should return the same readable values
        $this->assertEquals($expected, TestStatusStr::readable());
        $this->assertEquals($expected, TestStatusInt::readable());
        $this->assertEquals($expected, TestStatusUnbacked::readable());
    }

    /** @test */
    public function it_can_get_random_value()
    {
        // String backed enum
        $strRandom = TestStatusStr::random();
        $this->assertContains($strRandom, ['pending', 'in_progress', 'completed']);

        // Int backed enum
        $intRandom = TestStatusInt::random();
        $this->assertContains($intRandom, [1, 2, 3]);

        // Unbacked enum
        $plainRandom = TestStatusUnbacked::random();
        $this->assertContains($plainRandom, ['PENDING', 'IN_PROGRESS', 'COMPLETED']);
    }

    /** @test */
    public function it_can_convert_to_typescript()
    {
        // String backed enum
        $strTs = TestStatusStr::toTypeScript();
        $this->assertArrayHasKey('type', $strTs);
        $this->assertArrayHasKey('values', $strTs);
        $this->assertEquals('TestStatusStr', $strTs['type']);
        $this->assertEquals(['pending', 'in_progress', 'completed'], $strTs['values']);

        // Int backed enum
        $intTs = TestStatusInt::toTypeScript();
        $this->assertEquals('TestStatusInt', $intTs['type']);
        $this->assertEquals([1, 2, 3], $intTs['values']);

        // Unbacked enum
        $plainTs = TestStatusUnbacked::toTypeScript();
        $this->assertEquals('TestStatusUnbacked', $plainTs['type']);
        $this->assertEquals(['PENDING', 'IN_PROGRESS', 'COMPLETED'], $plainTs['values']);
    }

    /** @test */
    public function it_can_generate_validation_rules()
    {
        // String backed enum
        $strRules = TestStatusStr::rules();
        $strRulesExtra = TestStatusStr::rules(['nullable']);
        $this->assertEquals(
            ['required', 'string', 'in:pending,in_progress,completed'],
            $strRules
        );
        $this->assertEquals(
            ['required', 'string', 'in:pending,in_progress,completed', 'nullable'],
            $strRulesExtra
        );

        // Int backed enum
        $intRules = TestStatusInt::rules();
        $intRulesExtra = TestStatusInt::rules(['nullable']);
        $this->assertEquals(
            ['required', 'string', 'in:1,2,3'],
            $intRules
        );
        $this->assertEquals(
            ['required', 'string', 'in:1,2,3', 'nullable'],
            $intRulesExtra
        );

        // Unbacked enum
        $plainRules = TestStatusUnbacked::rules();
        $plainRulesExtra = TestStatusUnbacked::rules(['nullable']);
        $this->assertEquals(
            ['required', 'string', 'in:PENDING,IN_PROGRESS,COMPLETED'],
            $plainRules
        );
        $this->assertEquals(
            ['required', 'string', 'in:PENDING,IN_PROGRESS,COMPLETED', 'nullable'],
            $plainRulesExtra
        );
    }
}
