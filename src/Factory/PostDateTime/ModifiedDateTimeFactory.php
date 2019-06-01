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

use function get_post_modified_time;
use InvalidArgumentException;
use WordPressModel\Exception\InvalidPostDateTimeException;
use WordPressModel\Utils\Assert;
use WP_Post;

/**
 * Class ModifiedDateTimeFactory
 *
 * @internal
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class ModifiedDateTimeFactory implements DateTimeFactory
{
    use PostDateTimeFactoryTrait;

    /**
     * Retrieve the Modified Date Time for a Post
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

        $postDate = get_post_modified_time($format, $post);

        $this->bailIfInvalidValue($postDate, $post);

        return $postDate;
    }
}
