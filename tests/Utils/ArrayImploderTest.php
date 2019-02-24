<?php # -*- coding: utf-8 -*-

/*
 * This file is part of the WordPress Model package.
 *
 * (c) Guido Scialfa <dev@guidoscialfa.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace WordPressModel\Utils;

use WordPressModel\Utils\ArrayImplode as Testee;
use ProjectTestsHelper\Phpunit\TestCase;

/**
 * Class ArrayImploderTest
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class ArrayImploderTest extends TestCase
{
    /**
     * @var \ReflectionClass
     */
    private $reflectionTestee;

    public function testInstance()
    {
        $testee = new Testee();

        self::assertInstanceOf(Testee::class, $testee);
    }

    /**
     * @depences testInstance
     * @dataProvider isNumericDataProvider
     */
    public function testIsNumeric(array $data, bool $expectedValue)
    {
        $testeeMethod = $this
            ->reflectTestee()
            ->makePrivateMethodAccessible('isNumeric');
        $testee = $this
            ->getMockBuilder(Testee::class)
            ->disableOriginalConstructor()
            ->setConstructorArgs($data)
            ->getMock();

        $response = $testeeMethod->invoke($testee, $data);

        self::assertSame($expectedValue, $response);
    }

    public function isNumericDataProvider(): array
    {
        return [
            [
                [0, 1, 2],
                true,
            ],
            [
                [
                    '0' => 0,
                    '1' => 1,
                    '2' => 2,
                ],
                true,
            ],
            [
                [
                    '0zero' => 0,
                    '1one' => 1,
                    '2two' => 2,
                ],
                false,
            ],
            [
                [
                    'zero0' => 0,
                    'one1' => 1,
                    'two2' => 2,
                ],
                false,
            ],
            [
                [
                    'zero' => 0,
                    'one' => 1,
                    'two' => 2,
                ],
                false,
            ],
        ];
    }

    /**
     * @dataProvider byGlueProvider
     */
    public function testByGlue(array $data, string $expected)
    {
        $testeeMethod = $this
            ->reflectTestee()
            ->makePrivateMethodAccessible('byGlue');
        $testee = $this
            ->getMockBuilder(Testee::class)
            ->disableOriginalConstructor()
            ->setMethods(['isNumeric'])
            ->getMock();

        $result = $testeeMethod->invoke($testee, $data, ';', ':');

        static::assertSame($expected, $result);
    }

    public function byGlueProvider()
    {
        return [
            [
                [
                    'prop' => 'value',
                ],
                'prop:value',
            ],
            [
                [
                    'prop' => 'value',
                    'prop2' => 'value2',
                ],
                'prop:value;prop2:value2',
            ],
        ];
    }

    private function reflectTestee()
    {
        $this->reflectionTestee = new \ReflectionClass(Testee::class);

        return $this;
    }

    private function makePrivateMethodAccessible(string $methodName): \ReflectionMethod
    {
        $method = $this->reflectionTestee->getMethod($methodName);
        $method->setAccessible(true);

        return $method;
    }
}
