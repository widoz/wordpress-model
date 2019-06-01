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
use Throwable;
use WordPressModel\Exception\DateTimeException;
use WordPressModel\Exception\InvalidPostDateTimeException;
use WP_Post;

/**
 * Class PostDateTimeFactoryTrait
 *
 * @internal
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
trait PostDateTimeFactoryTrait
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
    ): DateTimeInterface {

        $postDate = $this->time($post, $format->date());
        $postTime = $this->time($post, $format->time());
        $separator = $format->separator();

        try {
            $dateTime = new DateTimeImmutable("{$postDate}{$separator}{$postTime}", $timeZone);
        } catch (Throwable $exc) {
            throw DateTimeException::fromException($exc);
        }

        return $dateTime;
    }

    /**
     * Throw InvalidPostDateException if date time is not a valid date or time string value.
     * Usually all of the WordPress functions return a string or a boolean (false) indicating
     * it was not possible to retrieve the post date or post time etc... values
     *
     * @param mixed $dateTime
     * @param WP_Post $post
     * @throws InvalidPostDateTimeException
     *
     * phpcs:disable Inpsyde.CodeQuality.ArgumentTypeDeclaration.NoArgumentType
     */
    protected function bailIfInvalidValue($dateTime, WP_Post $post): void
    {
        // phpcs:enable

        if ($dateTime === false) {
            throw InvalidPostDateTimeException::create($post);
        }
    }
}
