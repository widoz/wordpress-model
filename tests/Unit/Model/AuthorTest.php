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

namespace WordPressModel\Tests\Unit\Model;

use Brain\Monkey\Functions;
use Brain\Monkey\Filters;
use Widoz\Bem\Service;
use Widoz\Bem\Valuable;
use WordPressModel\Model\Author as Testee;
use ProjectTestsHelper\Phpunit\TestCase;

class AuthorTest extends TestCase
{
    public function testInstance()
    {
        $bem = $this->createMock(Service::class);
        $user = $this
            ->getMockBuilder('WP_User')
            ->getMock();

        $testee = new Testee($bem, $user);

        self::assertInstanceOf(Testee::class, $testee);
    }

    public function testEmptyDataIfUserDoesNotExists()
    {
        $bem = $this->createMock(Service::class);
        $user = $this
            ->getMockBuilder('WP_User')
            ->setMethods(['exists'])
            ->getMock();

        $user
            ->expects($this->once())
            ->method('exists')
            ->willReturn(false);

        $testee = new Testee($bem, $user);

        $data = $testee->data();

        self::assertEmpty($data);
    }

    public function testAuthorData()
    {
        $bem = $this->createMock(Service::class);
        $user = $this
            ->getMockBuilder('WP_User')
            ->setMethods(['exists'])
            ->getMock();
        $user->ID = 1;
        $user->display_name = ''; // Just for mock purpose

        Functions\expect('get_author_posts_url')
            ->once()
            ->with($user->ID)
            ->andReturn('Author Post Url');

        $user
            ->expects($this->once())
            ->method('exists')
            ->willReturn(true);

        $nameBemValue = $this->createMock(Valuable::class);
        $postsPageBemValue = $this->createMock(Valuable::class);
        $bem
            ->expects($this->exactly(2))
            ->method('forElement')
            ->withConsecutive(['name'], ['posts-page'])
            ->willReturnOnConsecutiveCalls(
                $nameBemValue,
                $postsPageBemValue
            );

        Filters\expectApplied(Testee::FILTER_DATA)
            ->once()
            ->with([
                'container' => [
                    'attributes' => [
                        'class' => $bem,
                    ],
                ],
                'name' => [
                    'text' => '',
                    'attributes' => [
                        'class' => $nameBemValue,
                    ],
                ],
                'link' => [
                    'attributes' => [
                        'href' => 'Author Post Url',
                        'class' => $postsPageBemValue,
                    ],
                ],
            ]);

        $testee = new Testee($bem, $user);

        $testee->data();
    }
}
