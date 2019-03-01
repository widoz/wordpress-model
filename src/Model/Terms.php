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

use Widoz\Bem\Service as ServiceBem;

/**
 * Post Terms Model
 */
final class Terms implements PartialModel
{
    public const FILTER_DATA = 'wordpressmodel.terms';

    /**
     * @var ServiceBem
     */
    private $bem;

    /**
     * @var string
     */
    private $taxonomy;

    /**
     * @var string
     */
    private $filter;

    /**
     * @var array
     */
    private $args;

    /**
     * Terms constructor
     * @param ServiceBem $bem
     * @param string $taxonomy
     * @param string $filter
     * @param array $args
     */
    public function __construct(
        ServiceBem $bem,
        string $taxonomy,
        string $filter = '',
        array $args = []
    ) {

        $this->bem = $bem;
        $this->taxonomy = $taxonomy;
        $this->filter = $filter;
        $this->args = $args;
    }

    /**
     * @return array
     */
    public function data(): array
    {
        $terms = $this->terms();

        if ($this->filter) {
            /**
             * Filter terms
             *
             * Filter terms by custom filter, useful if the instance is called for other type of
             * terms like tags or categories connected to posts.
             *
             * @params array $terms The terms to filter.
             */
            $terms = apply_filters($this->filter, $terms);
        }

        /**
         * Filter Terms
         *
         * @params array $terms The terms to filter.
         */
        return apply_filters(self::FILTER_DATA, $terms);
    }

    /**
     * @return array
     */
    private function terms(): array
    {
        $items = [];
        $terms = \get_terms(\array_merge($this->args, [
            'taxonomy' => $this->taxonomy,
        ]));

        if (!$terms
            || !\is_array($terms)
            || \is_wp_error($terms)
        ) {
            return [];
        }

        foreach ($terms as $term) {
            $items[$term->slug] = [
                'name' => $term->name,
                'attributes' => [
                    'class' => $this->bem->forElement('term'),
                ],
                'link' => [
                    'attributes' => [
                        'class' => $this->bem->forElement('link'),
                        'href' => $this->termLink($term),
                    ],
                ],
            ];
        }

        return $items;
    }

    /**
     * @param \WP_Term $term
     *
     * @return string
     */
    private function termLink(\WP_Term $term): string
    {
        $link = \get_term_link($term, $this->taxonomy);

        if (\is_wp_error($link)) {
            $link = '';
        }

        return $link;
    }
}
