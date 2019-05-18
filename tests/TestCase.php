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

namespace WordPressModel\Tests;

use PHPUnit\Framework\MockObject\MockBuilder;
use ProjectTestsHelper\Phpunit\TestCase as PhpunitTestCase;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

/**
 * Class TestCase
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class TestCase extends PhpunitTestCase
{
    /**
     * Build the Testee Mock Object
     *
     * Basic configuration available for all of the testee objects, call `getMock` to get the mock.
     *
     * @param string $className
     * @param array $constructorArguments
     * @param array $methods
     * @return MockBuilder
     */
    protected function buildTesteeMock(
        string $className,
        array $constructorArguments,
        array $methods
    ): MockBuilder {

        $testee = $this->getMockBuilder($className);

        $constructorArguments
            ? $testee->setConstructorArgs($constructorArguments)
            : $testee->disableOriginalConstructor();

        if ($methods) {
            $testee->setMethods($methods);
        }

        return $testee;
    }

    /**
     * Retrieve a Testee Mock to Test Protected Methods
     *
     * return MockBuilder
     * @param string $className
     * @param array $constructorArguments
     * @param string $method
     * @return array
     * @throws ReflectionException
     */
    public function buildTesteeMethodMock(
        string $className,
        array $constructorArguments,
        string $method
    ): array {

        $testee = $this->buildTesteeMock($className, $constructorArguments, [])->getMock();

        $reflectionMethod = new ReflectionMethod($className, $method);
        $reflectionMethod->setAccessible(true);

        return [
            $testee,
            $reflectionMethod,
        ];
    }
}
