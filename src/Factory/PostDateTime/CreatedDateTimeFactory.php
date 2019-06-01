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

use function get_post_time;
use InvalidArgumentException;
use WordPressModel\Exception\InvalidPostDateTimeException;
use WordPressModel\Utils\Assert;
use WP_Post;

/**
 * Class DateTimeFactory
 *
 * @internal
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class CreatedDateTimeFactory implements DateTimeFactory
{
    use PostDateTimeFactoryTrait;

    /**
     * Retrieve the Written Time for a Post
     *
     * @param WP_Post $post
     * @param string $format
     * @return string
     * @throws InvalidArgumentException
     * @throws InvalidPostDateTimeException
     */
    protected function time(WP_Post $post, string $format): string
    {
        Assert::stringNotEmpty($format);

        $postTime = get_post_time($format, false, $post, false);

        $this->bailIfInvalidValue($postTime, $post);

        return $postTime;
    }
}
