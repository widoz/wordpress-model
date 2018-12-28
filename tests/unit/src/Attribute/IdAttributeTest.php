<?php # -*- coding: utf-8 -*-

/*
 * This file is part of the WordPress Theme Model package.
 *
 * (c) Guido Scialfa <dev@guidoscialfa.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WordPressModel\Tests\Unit\Attribute;

use WordPressModel\Model\Attribute\IdAttribute;
use WordPressModel\Tests\TestCase;

class IdAttributeTest extends TestCase
{
    public function testInstance()
    {
        $sut = new IdAttribute('value');

        $this->assertInstanceOf('\\WordPressModel\\Attribute\\IdAttribute', $sut);
    }

    public function testValue()
    {
        $sut = new IdAttribute('value');

        $value = $sut->value();

        $this->assertSame('value', $value);
    }

    public function testValueWithPrefix()
    {
        $sut = new IdAttribute('value', 'prefix_');

        $value = $sut->value();

        $this->assertSame('prefix_value', $value);
    }

    public function testAttribute()
    {
        \Brain\Monkey\Functions\when('sanitize_html_class')
            ->returnArg(1);

        $sut = new IdAttribute('block');

        echo $sut;

        $this->expectOutputString('id="block"');
    }
}
