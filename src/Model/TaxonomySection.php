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

use Widoz\Bem;

/**
 * TaxonomySection Model
 */
final class TaxonomySection implements FullFilledModel
{
    public const FILTER_DATA = 'wordpressmodel.post_category';

    /**
     * @var Bem\Service
     */
    private $bem;

    /**
     * @var Model
     */
    private $terms;

    /**
     * @var string
     */
    private $title;

    /**
     * Category constructor
     * @param Bem\Service $bem
     * @param Model $terms
     * @param string $title
     */
    public function __construct(Bem\Service $bem, Model $terms, string $title)
    {
        $this->bem = $bem;
        $this->terms = $terms;
        $this->title = $title;
    }

    /**
     * @return array
     */
    public function data(): array
    {
        /**
         * Category Filter
         *
         * @param array $category The post terms category to filter.
         */
        return apply_filters(self::FILTER_DATA, [
            'container' => [
                'attributes' => [
                    'class' => $this->bem,
                ],
            ],
            'title' => [
                'content' => $this->title,
                'attributes' => [
                    'class' => $this->bem->forElement('title'),
                ],
            ],
            'terms' => [
                'items' => $this->terms->data(),
                'attributes' => [
                    'class' => $this->bem->forElement('terms'),
                ],
            ],
        ]);
    }
}
