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

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use InvalidArgumentException;
use WordPressModel\Exception\DateTimeException;
use WordPressModel\Exception\InvalidPostDateTimeException;
use WP_Post;

/**
 * Interface DateTimeFactory
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
interface DateTimeFactory
{
    /**
     * Retrieve the Date Time for a Post
     *
     * @param WP_Post $post
     * @param DateTimeFormat $format
     * @param DateTimeZone $timeZone
     * @return DateTimeImmutable
     * @throws DateTimeException
     * @throws InvalidArgumentException
     * @throws InvalidPostDateTimeException
     */
    public function create(
        WP_Post $post,
        DateTimeFormat $format,
        DateTimeZone $timeZone
    ): DateTimeInterface;
}
