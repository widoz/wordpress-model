<?php # -*- coding: utf-8 -*-

/*
 * This file is part of the WordPress Theme Model package.
 *
 * (c) Guido Scialfa <dev@guidoscialfa.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace WordPressModel\Model;

use Widoz\Bem\Factory;
use Widoz\Bem\Service as ServiceBem;

/**
 * Pagination Model
 */
final class Pagination implements FullFilledModel
{
    public const FILTER_DATA = 'wordpressmodel.pagination';

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
        $bem = Factory::createServiceForStandard('pagination');
        $base = \str_replace(PHP_INT_MAX, '%#%', \esc_url(\get_pagenum_link(PHP_INT_MAX)));
        $previous = \esc_html__('Previous Page', 'wordpress-model');
        $next = \esc_html__('Next Page', 'wordpress-model');
        $beforePage = \esc_html__('Page', 'wordpress-model');

        add_filter(
            self::FILTER_DATA,
            function (array $data) use ($bem): array {
                return $this->makePaginationMarkupClassesBemLike($data, $bem);
            }
        );

        /**
         * Pagination Data
         *
         * @param array $data The pagination data.
         */
        $data = apply_filters(self::FILTER_DATA, [
            'container' => [
                'attributes' => [
                    'class' => $bem,
                ],
            ],
            'list' => [
                'links' => [
                    'markup' => \paginate_links(
                        [
                            'base' => $base,
                            'format' => '?paged=%#%',
                            'aria_current' => $this->query->get('post_type'),
                            'current' => \max(1, $this->query->get('paged')),
                            'total' => $this->query->max_num_pages,
                            'prev_text' => \sprintf('&larr; %s', $previous),
                            'next_text' => \sprintf('%s &rarr;', $next),
                            'type' => 'array',
                            'before_page_number' => '<span class="screen-reader-text">' . $beforePage . ' </span>',
                        ]
                    ),
                ],
                'attributes' => [
                    'class' => $bem->forElement('pagination-links'),
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
     * @param ServiceBem $bem
     *
     * @return array The filtered data
     */
    public function makePaginationMarkupClassesBemLike(array $data, ServiceBem $bem): array
    {
        \array_walk(
            $data['links'],
            function (string &$item) use ($bem) {
                $item = \str_replace(
                    'page-numbers',
                    \sanitize_html_class($bem->forElement('page-link')),
                    $item
                );
            }
        );

        return $data;
    }
}
