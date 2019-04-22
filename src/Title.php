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

use function get_post;
use function get_the_archive_title;
use WP_Post;

/**
 * Class Title
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class Title
{
    private const OPTION_PAGE_FOR_POSTS = 'page_for_posts';

    /**
     * @return string
     */
    public function forHome(): string
    {
        $title = '';
        $homePost = get_post((int)get_option(self::OPTION_PAGE_FOR_POSTS, 0));

        if ($homePost instanceof WP_Post) {
            /** @var WP_Post $homePost */
            $title = $homePost->post_title;
        }

        return $title;
    }

    /**
     * @return string
     */
    public function forArchive(): string
    {
        return get_the_archive_title();
    }
}
