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

use function get_header_textcolor;
use function sanitize_hex_color_no_hash;
use function trim;
use InvalidArgumentException;
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
     * @inheritDoc
     * @throws InvalidArgumentException
     */
    public function data(): array
    {
        $blogName = trim(get_bloginfo('name'));

        if (!$blogName) {
            /**
             * Filter Data
             *
             * @param array $data The data for the template to filter.
             */
            return apply_filters(self::FILTER_DATA, []);
        }

        $headerTextColor = $this->cssProperties->flat([
            'color' => '#' . sanitize_hex_color_no_hash(get_header_textcolor()),
        ]);

        $data = [
            'container' => [
                'attributes' => [
                    'class' => $this->bem,
                ],
            ],
            'name' => [
                'content' => $blogName,
            ],
            'link' => [
                'attributes' => [
                    'href' => home_url('/'),
                    'class' => $this->bem->forElement('link'),
                    'style' => $headerTextColor,
                ],
            ],
            'description' => [
                'content' => get_bloginfo('description'),
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
}
