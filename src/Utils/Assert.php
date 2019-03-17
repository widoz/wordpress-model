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

use Webmozart\Assert\Assert as WebMozartAssert;

/**
 * Class Assert
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
final class Assert extends WebMozartAssert
{
    /**
     * @param array $array
     * @param string|null $message
     * @throws \InvalidArgumentException
     */
    public static function isStringValueMap(array $array, string $message = null): void
    {
        static::isMap($array, $message);

        $isString = \array_filter($array, '\is_string');

        if (!$isString) {
            static::reportInvalidArgument(
                $message ?: 'Expect map of strings - All values of map are strings.'
            );
        }
    }
}
