<?php # -*- coding: utf-8 -*-

/*
 * This file is part of the WordPress Theme Model package.
 *
 * (c) Guido Scialfa <dev@guidoscialfa.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace WordPressModel\Attribute;

/**
 * Attribute
 */
interface Attribute
{
    /**
     * @return string The attribute value
     */
    public function value(): string;

    /**
     * @return string The attribute and his value
     */
    public function __toString(): string;
}
