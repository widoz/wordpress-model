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

namespace WordPressModel\Tests\Unit\Attachment\Image;

use Brain\Monkey\Functions;
use ProjectTestsHelper\Phpunit\TestCase;
use WordPressModel\Attachment\Image\Size;
use WordPressModel\Attachment\Image\Source;
use WordPressModel\Attachment\Image\SourceFactory as Testee;
use InvalidArgumentException;

/**
 * Class SourceFactoryTest
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class SourceFactoryTest extends TestCase
{
    /**
     * Test SourceFactory Instance
     */
    public function testInstance()
    {
        self::assertInstanceOf(Testee::class, new Testee());
    }

    /**
     * Test Source Instantiation
     */
    public function testSourceInstance()
    {
        $this->expectException(InvalidArgumentException::class);

        $attachment = $this
            ->getMockBuilder('WP_Post')
            ->getMock();
        $attachment->ID = 1;

        $size = $this->createMock(Size::class);

        $testee = $this
            ->getMockBuilder(Testee::class)
            ->setMethods(null)
            ->getMock();

        Functions\expect('wp_attachment_is_image')
            ->once()
            ->with($attachment)
            ->andReturn(true);

        Functions\expect('wp_get_attachment_image_src')
            ->once()
            ->andReturn([
                0 => 'string',
                1 => 1,
                2 => 2,
                3 => true
            ]);

        $source = $testee->create($attachment, $size);

        self::assertEquals(new Source('string', 1, 2, true), $source);
    }
}
