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

/**
 * Implode Array Elements Utility
 */
class ImplodeArray
{
    /**
     * @var array
     */
    private $array;

    /**
     * ImplodeArray constructor.
     *
     * @param array $array
     */
    public function __construct(array $array)
    {
        $this->array = $array;
    }

    /**
     * Implode an array to be used for the `style` attribute markup.
     * Where key is the attribute name.
     *
     * @return string
     */
    public function forAttributeStyle(): string
    {
        return $this->byGlue(';', ':');
    }

    /**
     * Implode associative array by passing the glue to separate key/value group
     * and assGlue to separate key from value.
     *
     * @param string $glue
     * @param string $assGlue
     * @return string
     */
    private function byGlue(string $glue, string $assGlue): string
    {
        if ($this->isNumeric($this->array)) {
            return '';
        }

        $string = '';
        foreach ($this->array as $key => $value) {
            if (!$value) {
                continue;
            }

            $string .= $key . $assGlue . $value . $glue;
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
        $numericArray = array_filter(array_keys($data), 'is_numeric');

        return count($numericArray) > 0;
    }
}
