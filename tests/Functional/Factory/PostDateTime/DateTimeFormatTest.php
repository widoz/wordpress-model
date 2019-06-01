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

namespace WordPressModel\Tests\Unit\Factory\PostDateTime;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use ProjectTestsHelper\Phpunit\TestCase;
use WordPressModel\Factory\PostDateTime\DateTimeFormat as Testee;

/**
 * Class DateTimeFormatTest
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class DateTimeFormatTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * Test Data
     */
    public function testData()
    {
        {
            $dateStub = date('Y/m/d');
            $timeStub = date('H:i:s');
            $separatorStub = ' ';

            $testee = new Testee($dateStub, $timeStub, $separatorStub);
        }

        {
            /** @var Testee $testee */
            self::assertSame($dateStub, $testee->date());
            self::assertSame($timeStub, $testee->time());
            self::assertSame($separatorStub, $testee->separator());
        }
    }
}
