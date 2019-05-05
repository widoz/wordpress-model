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

namespace WordPressModel;

use function get_the_date;
use function get_the_modified_date;
use function get_the_modified_time;
use function get_the_time;
use function implode;
use InvalidArgumentException;
use WordPressModel\Exception\InvalidPostDateException;
use WordPressModel\Utils\Assert;
use WP_Post;

/**
 * Class DateTime
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class DateTime
{
    /**
     * Retrieve the Modified Date for a Post
     *
     * @param WP_Post $post
     * @param string $format
     * @return string
     * @throws InvalidArgumentException
     * @throws InvalidPostDateException
     */
    public function modifiedDate(WP_Post $post, string $format): string
    {
        Assert::stringNotEmpty($format);

        $postDate = get_the_modified_date($format, $post);

        $this->bailIfInvalidValue($postDate, $post);

        return $postDate;
    }

    /**
     * Retrieve the Modified Time for a Post
     *
     * @param WP_Post $post
     * @param string $format
     * @return string
     * @throws InvalidArgumentException
     * @throws InvalidPostDateException
     */
    public function modifiedTime(WP_Post $post, string $format): string
    {
        Assert::stringNotEmpty($format);

        $postDate = get_the_modified_time($format, $post);

        $this->bailIfInvalidValue($postDate, $post);

        return $postDate;
    }

    /**
     * Retrieve the Written Date for a Post
     *
     * @param WP_Post $post
     * @param string $format
     * @return string
     * @throws InvalidArgumentException
     * @throws InvalidPostDateException
     */
    public function date(WP_Post $post, string $format): string
    {
        Assert::stringNotEmpty($format);

        $postDate = get_the_date($format, $post);

        $this->bailIfInvalidValue($postDate, $post);

        return $postDate;
    }

    /**
     * Retrieve the Written Time for a Post
     *
     * @param WP_Post $post
     * @param string $format
     * @return string
     * @throws InvalidArgumentException
     * @throws InvalidPostDateException
     */
    public function time(WP_Post $post, string $format): string
    {
        Assert::stringNotEmpty($format);

        $postTime = get_the_time($format, $post);

        $this->bailIfInvalidValue($postTime, $post);

        return $postTime;
    }

    /**
     * Retrieve the Written Date Time for a Post
     *
     * @param WP_Post $post
     * @param string $format
     * @param string $separator
     * @return string
     * @throws InvalidArgumentException
     * @throws InvalidPostDateException
     *
     * phpcs:disable Generic.NamingConventions.ConstructorName.OldStyle
     */
    public function dateTime(WP_Post $post, string $format, string $separator): string
    {
        // phpcs:enable

        Assert::stringNotEmpty($format);
        Assert::stringNotEmpty($separator);

        $postDate = $this->date($post, $format);
        $postTime = $this->time($post, $format);

        return implode([$postDate, $postTime], $separator);
    }

    /**
     * Throw InvalidPostDateException if date time is not a valid date or time string value.
     * Usually all of the WordPress functions return a string or a boolean (false) indicating
     * it was not possible to retrieve the post date or post time etc... values
     *
     * @param mixed $dateTime
     * @param WP_Post $post
     * @throws InvalidPostDateException
     *
     * phpcs:disable Inpsyde.CodeQuality.ArgumentTypeDeclaration.NoArgumentType
     */
    private function bailIfInvalidValue($dateTime, WP_Post $post): void
    {
        // phpcs:enable

        if ($dateTime === false) {
            throw InvalidPostDateException::create($post);
        }
    }
}
