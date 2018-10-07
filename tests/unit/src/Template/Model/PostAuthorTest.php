<?php # -*- coding: utf-8 -*-

/*
 * This file is part of the WordPress Theme Model Theme package.
 *
 * (c) Guido Scialfa <dev@guidoscialfa.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WordPressModel\Tests\Unit\Model;

use WordPressModel\Author;
use WordPressModel\Tests\TestCase;

/**
 * Class PostAuthorTest
 */
class PostAuthorTest extends TestCase
{
    public function testUserNotExistsReturnsEmptyData()
    {
        $userMock = \Mockery::mock('\WP_User');
        $userMock
            ->shouldReceive('exists')
            ->once()
            ->andReturn(false);

        $sut = new Author($userMock);
        $data = $sut->data();

        self::assertEmpty($data);
    }
}
