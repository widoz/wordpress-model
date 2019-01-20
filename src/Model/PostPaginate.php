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
use Widoz\Bem\Valuable;

/**
 * Paginate Post Model
 */
final class PostPaginate implements FullFilledModel
{
    public const FILTER_DATA = 'wordpressmodel.post_paginate';
    public const FILTER_PAGINATE_LIST = 'wp_link_pages_link';

    /**
     * @inheritdoc
     */
    public function data(): array
    {
        $bem = Factory::createServiceForStandard('pagination');

        if (!$this->isMultipage()) {
            /**
             * Post Paginate Filter
             *
             * @param array $data The post paginate data
             */
            return apply_filters(self::FILTER_DATA, []);
        }

        add_filter(
            self::FILTER_PAGINATE_LIST,
            [$this, 'makePaginationMarkupClassesBemLike'],
            0
        );

        /**
         * Post Paginate Filter
         *
         * @param array $data The post paginate data
         */
        $data = apply_filters(self::FILTER_DATA, [
            'container' => [
                'attributes' => [
                    'class' => $bem,
                ],
            ],
            'markup' => wp_link_pages([
                'echo' => 0,
                'before' => $this->before($bem->value()),
                'after' => $this->after(),
                'link_before' => $this->linkBefore(),
            ]),
        ]);

        remove_filter(
            self::FILTER_PAGINATE_LIST,
            [$this, 'makePaginationMarkupClassesBemLike'],
            0
        );

        return $data;
    }

    /**
     * @return mixed
     */
    private function isMultipage(): bool
    {
        global $multipage;

        return $multipage;
    }

    /**
     * Make Pagination Attribute Class Bem Like
     * Change the class attribute value with ones that provide bem like string.
     *
     * @param string $link
     *
     * @return string The filtered link
     */
    public function makePaginationMarkupClassesBemLike(string $link): string
    {
        $bem = Factory::createServiceForStandard('pagination');

        $link = '<li class="' . sanitize_html_class($bem->forElement('item')) . '">' . $link . '</li>';

        return $link;
    }

    /**
     * @param Valuable $bem
     * @return string
     */
    private function before(Valuable $bem): string
    {
        return '<ul class="' . sanitize_html_class($bem) . '">';
    }

    /**
     * @return string
     */
    private function after(): string
    {
        return '</ul>';
    }

    /**
     * @return string
     */
    private function linkBefore(): string
    {
        return sprintf(
            '<span class="screen-reader-text">%s</span>',
            esc_html_x('Page', 'pagination', 'wordpress-model')
        );
    }
}
