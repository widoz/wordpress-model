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
    public static function isStringValueMap(array $array, string $message = null)
    {
        static::isMap($array, $message);

        // phpcs:ignore Inpsyde.CodeQuality.ArgumentTypeDeclaration.NoArgumentType
        $isString = array_filter($array, function ($value): bool {
            return is_string($value);
        });

        if (!$isString) {
            static::reportInvalidArgument(
                $message ?: 'Expect map of strings - All values of map are strings.'
            );
        }
    }
}
