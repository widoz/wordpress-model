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

use InvalidArgumentException;

/**
 * Class Style
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class CssProperties
{
    /**
     * @var ArrayImplode
     */
    private $arrayImploder;

    /**
     * CssProperties constructor
     * @param ArrayImplode $arrayImploder
     */
    public function __construct(ArrayImplode $arrayImploder)
    {
        $this->arrayImploder = $arrayImploder;
    }

    /**
     * Flat a list of css properties. The list have to be in form of an associative array.
     *
     * @uses ArrayImplode::byGlue to flat the array.
     * @param array $properties
     * @return string
     * @throws InvalidArgumentException
     */
    public function flat(array $properties): string
    {
        Assert::isMap($properties);

        return $this->arrayImploder->byGlue($properties, ';', ':');
    }
}
