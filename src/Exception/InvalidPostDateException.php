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

namespace WordPressModel\Exception;

use WP_Post;

/**
 * Class InvalidPostDateException
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class InvalidPostDateException extends InvalidPostException
{
    /**
     * Create a New Instance of InvalidPostDateException
     *
     * @param WP_Post $post
     * @return InvalidPostDateException
     */
    public static function create(WP_Post $post): self
    {
        return new self("Invalid post date time retrieved for post with ID: {$post->ID}");
    }
}
