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

namespace WordPressModel\Model;

/**
 * Class Description
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class Description
{
    public const FILTER_HOME_PAGE_DESCRIPTION = 'wordpressmodel.home_page_description';
    private const OPTION_PAGE_FOR_POSTS = 'page_for_posts';

    /**
     * @return string
     */
    public function forHome(): string
    {
        $description = '';
        $homePost = get_post((int)get_option(self::OPTION_PAGE_FOR_POSTS, 0));

        if ($homePost instanceof \WP_Post) {
            /** @var \WP_Post $homePost */
            $description = $homePost->post_excerpt;
        }

        $description = apply_filters(
            self::FILTER_HOME_PAGE_DESCRIPTION,
            $description
        );

        return (string)$description;
    }

    /**
     * @return string
     */
    public function forArchive(): string
    {
        return get_the_archive_description();
    }
}
