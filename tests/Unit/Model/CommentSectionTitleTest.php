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

namespace WordPressModel\Model;

use Brain\Monkey\Filters;
use Widoz\Bem\Service;
use Widoz\Bem\Valuable;
use WordPressModel\Model\CommentSectionTitle as Testee;
use ProjectTestsHelper\Phpunit\TestCase;

/**
 * Class CommentSectionTitleTest
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class CommentSectionTitleTest extends TestCase
{
    /**
     * Test Instance
     */
    public function testInstance()
    {
        $bem = $this->createMock(Service::class);
        $testee = new Testee($bem, 'Comments Section Title');

        self::assertInstanceOf(Testee::class, $testee);
    }

    /**
     * Test Data Model Contains Correct Values and Filter is Applied
     */
    public function testFilterGetAppliedWithCorrectData()
    {
        $bem = $this->createMock(Service::class);
        $testee = new Testee($bem, 'Comments Section Title');

        $titleValue = $this->createMock(Valuable::class);
        $bem
            ->expects($this->once())
            ->method('forElement')
            ->with('title')
            ->willReturn($titleValue);

        Filters\expectApplied(Testee::FILTER_DATA)
            ->once()
            ->with([
                'title' => [
                    'text' => 'Comments Section Title',
                    'attributes' => [
                        'class' => $titleValue,
                    ],
                ],
            ]);

        $testee->data();

        self::assertTrue(true);
    }
}
