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

namespace WordPressModel\Utils;

use function array_filter;
use function array_keys;
use function rtrim;

/**
 * Implode Array Elements Utility
 */
class ArrayImplode
{
    /**
     * Implode associative array by passing the glue to separate key/value group
     * and assGlue to separate key from value.
     *
     * @param array $properties
     * @param string $glue
     * @param string $assGlue
     * @return string
     */
    public function byGlue(array $properties, string $glue, string $assGlue): string
    {
        if ($this->isNumeric($properties)) {
            return '';
        }

        $string = '';
        foreach ($properties as $key => $value) {
            if (!$value) {
                continue;
            }

            $string .= "{$key}{$assGlue}{$value}{$glue}";
        }
        $string = rtrim($string, $glue);

        return $string;
    }

    /**
     * May be the array is numeric or associative
     *
     * @param array $data
     * @return bool
     */
    private function isNumeric(array $data): bool
    {
        /** @noinspection UnqualifiedReferenceInspection */
        $numericArray = array_filter(array_keys($data), 'is_numeric');

        return count($numericArray) > 0;
    }
}
