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

use Widoz\Bem\BemPrefixed;

/**
 * Paginate Post Model
 */
final class PostPaginate implements Model
{
    private const FILTER_DATA = 'wordpressmodel.template_data_post_paginate';

    /**
     * @var string
     */
    private static $paginateLinkFilter = 'wp_link_pages_link';

    /**
     * @inheritdoc
     */
    public function data(): array
    {
        if (! $this->isMultipage()) {
            return [];
        }

        add_filter(
            self::$paginateLinkFilter,
            [$this, 'makePaginationMarkupClassesBemLike'],
            0
        );

        $data = apply_filters(self::FILTER_DATA, [
            'pagination' => wp_link_pages([
                'echo' => 0,
                'before' => $this->before(),
                'after' => $this->after(),
                'link_before' => $this->linkBefore(),
            ]),
        ]);

        remove_filter(
            self::$paginateLinkFilter,
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
        $class = new BemPrefixed('pagination', 'item');

        $link = '<li class="' . sanitize_html_class($class->value()) . '">' . $link . '</li>';

        return $link;
    }

    /**
     * @return string
     */
    private function before(): string
    {
        $class = new BemPrefixed('pagination');

        return '<ul class="' . sanitize_html_class($class->value()) . '">';
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
        return '<span class="screen-reader-text">' . esc_html__('Page', 'wordpress-model') . '</span> ';
    }
}
