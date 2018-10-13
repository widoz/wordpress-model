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

use WordPressModel\Attribute\ClassAttribute;
use Widoz\Bem\BemPrefixed;

/**
 * Pagination Model
 */
final class Pagination implements Model
{
    private const FILTER_DATA = 'wordpressmodel.pagination';

    /**
     * @var \WP_Query The query which build the pagination for
     */
    private $query;

    /**
     * Pagination constructor
     *
     * @param \WP_Query $query The query which build the pagination for.
     */
    public function __construct(\WP_Query $query)
    {
        $this->query = $query;
    }

    /**
     * @inheritdoc
     */
    public function data(): array
    {
        $base = str_replace(PHP_INT_MAX, '%#%', esc_url(get_pagenum_link(PHP_INT_MAX)));
        $previous = esc_html__('Previous Page', 'wordpress-model');
        $next = esc_html__('Next Page', 'wordpress-model');
        $beforePage = esc_html__('Page', 'wordpress-model');

        add_filter(
            self::FILTER_DATA,
            [$this, 'makePaginationMarkupClassesBemLike']
        );

        $classContainer = new ClassAttribute(new BemPrefixed('pagination'));
        $classList = new ClassAttribute(new BemPrefixed('pagination-links'));

        /**
         * Pagination Data
         *
         * @param array $data The pagination data.
         */
        $data = apply_filters(self::FILTER_DATA, [
            'container' => [
                'attributes' => [
                    'class' => $classContainer->value(),
                ],
            ],
            'list' => [
                'links' => [
                    'markup' => paginate_links(
                        [
                            'base' => $base,
                            'format' => '?paged=%#%',
                            'aria_current' => $this->query->get('post_type'),
                            'current' => max(1, $this->query->get('paged')),
                            'total' => $this->query->max_num_pages,
                            'prev_text' => sprintf('&larr; %s', $previous),
                            'next_text' => sprintf('%s &rarr;', $next),
                            'type' => 'array',
                            'before_page_number' => '<span class="screen-reader-text">' . $beforePage . ' </span>',
                        ]
                    ),
                ],
                'attributes' => [
                    'class' => $classList->value(),
                ],
            ],
        ]);

        return $data;
    }

    /**
     * Make Pagination Attribute Class Bem Like
     * Change the class attribute value with ones that provide bem like string.
     *
     * @param array $data The array from which extract the links to modify.
     *
     * @return array The filtered data
     */
    public function makePaginationMarkupClassesBemLike(array $data): array
    {
        array_walk(
            $data['links'],
            function (string &$item) {
                $item = str_replace(
                    'page-numbers',
                    sanitize_html_class((new BemPrefixed('page-links', 'link'))->value()),
                    $item
                );
            }
        );

        // Remove after done.
        remove_filter(
            self::FILTER_DATA,
            [$this, 'makePaginationMarkupClassesBemLike']
        );

        return $data;
    }
}
