<?php # -*- coding: utf-8 -*-

/*
 * This file is part of the WordPress Theme Model Theme package.
 *
 * (c) Guido Scialfa <dev@guidoscialfa.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace WordPressModel;

/**
 * Paginate Comments Links Model
 */
final class PaginateCommentsLinks implements Model
{
    private const FILTER_DATA = 'wordpressmodel.paginate_comments_links';

    /**
     * @return array
     */
    public function data(): array
    {
        if (get_comment_pages_count() === 1) {
            /**
             * Paginate Comments Links Data
             *
             * @param array $data The data arguments for the template.
             */
            return apply_filters(self::FILTER_DATA, []);
        }

        /**
         * Paginate Comments Links Data
         *
         * @param array $data The data arguments for the template.
         */
        return apply_filters(self::FILTER_DATA, [
            'container' => [
                'markup' => paginate_comments_links([
                    'type' => 'list',
                    'before_page_number' => sprintf(
                        '<span class="screen-reader-text">%s </span>',
                        esc_html__('Page', 'wordpress-model')
                    ),
                    'prev_text' => sprintf(
                        '&larr; <span class="screen-reader-text">%s</span>',
                        esc_html__('Previous Comments', 'wordpress-model')
                    ),
                    'next_text' => sprintf(
                        '<span class="screen-reader-text">%s</span> &rarr;',
                        esc_html__('Next Comments', 'wordpress-model')
                    ),
                ]),
            ],
        ]);
    }
}
