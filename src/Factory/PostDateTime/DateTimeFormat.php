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

namespace WordPressModel\Factory\PostDateTime;

use WordPressModel\Utils\Assert;

/**
 * Class DateTimeFormat
 *
 * @internal
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class DateTimeFormat
{
    /**
     * @var string
     */
    private $date;

    /**
     * @var string
     */
    private $time;

    /**
     * @var string
     */
    private $separator;

    /**
     * DateTimeFormat constructor
     * @param string $date
     * @param string $time
     * @param string $separator
     */
    public function __construct(string $date, string $time, string $separator)
    {
        Assert::stringNotEmpty($date);
        Assert::stringNotEmpty($time);
        Assert::stringNotEmpty($separator);

        $this->date = $date;
        $this->time = $time;
        $this->separator = $separator;
    }

    /**
     * Retrieve the Date
     *
     * @return string
     */
    public function date(): string
    {
        return $this->date;
    }

    /**
     * Retrieve the Time
     *
     * @return string
     */
    public function time(): string
    {
        return $this->time;
    }

    /**
     * Retrieve the Separator used to separate Date and Time Values
     *
     * @return string
     */
    public function separator(): string
    {
        return $this->separator;
    }
}
