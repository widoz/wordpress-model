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

use Widoz\Bem\Service as BemService;
use WordPressModel\Utils\CssProperties;

/**
 * Brand Model
 */
final class Brand implements FullFilledModel
{
    public const FILTER_DATA = 'wordpressmodel.brand_logo';

    /**
     * @var BemService
     */
    private $bem;

    /**
     * @var CssProperties
     */
    private $cssProperties;

    /**
     * Brand constructor
     * @param BemService $bem
     * @param CssProperties $cssProperties
     */
    public function __construct(BemService $bem, CssProperties $cssProperties)
    {
        $this->bem = $bem;
        $this->cssProperties = $cssProperties;
    }

    /**
     * @return array
     */
    public function data(): array
    {
        if (!$this->mayBeDisplayed()) {
            /**
             * Filter Data
             *
             * @param array $data The data for the template to filter.
             */
            return apply_filters(self::FILTER_DATA, []);
        }

        $style = $this->cssProperties->flat([
            'color' => '#' . \sanitize_hex_color_no_hash(\get_header_textcolor()),
        ]);

        $data = [
            'container' => [
                'attributes' => [
                    'class' => $this->bem,
                ],
            ],
            'name' => [
                'text' => get_bloginfo('name'),
            ],
            'link' => [
                'attributes' => [
                    'href' => home_url('/'),
                    'class' => $this->bem->forElement('link'),
                    'style' => $style,
                ],
            ],
            'description' => [
                'text' => get_bloginfo('description'),
                'attributes' => [
                    'class' => $this->bem->forElement('description'),
                ],
            ],
        ];

        /**
         * Filter Data
         *
         * @param array $data The data for the template to filter.
         */
        return apply_filters(self::FILTER_DATA, $data);
    }

    /**
     * @return bool
     */
    private function mayBeDisplayed(): bool
    {
        return (bool)\trim(get_bloginfo('name'));
    }
}
