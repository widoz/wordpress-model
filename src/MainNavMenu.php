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
use WordPressModel\Attribute\IdAttribute;
use Widoz\Bem\BemPrefixed;

/**
 * Main Nav Menu Model
 */
final class MainNavMenu implements Model
{
    private const FILTER_DATA = 'wordpressmodel.template_data_main_nav_menu';
    const FILTER_JUMP_TO_CONTENT_HREF = 'wordpressmodel.template_data_menu_jump_to_content_href';

    /**
     * @var int
     */
    private $depth;

    /**
     * @var callable
     */
    private $fallback;

    /**
     * @var string
     */
    private $themeLocation;

    /**
     * @var string
     */
    private $id;

    /**
     * @var \Walker
     */
    private $walker;

    /**
     * MainNavMenu constructor.
     * @param string $themeLocation
     * @param string $id
     * @param int $depth
     * @param callable|null $fallback
     * @param \Walker|null $walker
     */
    public function __construct(
        string $themeLocation,
        string $id = '',
        int $depth = 2,
        callable $fallback = null,
        \Walker $walker = null
    ) {

        $this->themeLocation = $themeLocation;
        $this->id = $id;
        $this->depth = $depth;
        $this->fallback = $fallback;
        $this->walker = $walker;
    }

    /**
     * @return array
     */
    public function data(): array
    {
        if (!$this->hasNavMenu()) {
            return [];
        }

        $id = new IdAttribute('main-menu');
        $class = new ClassAttribute(new BemPrefixed('nav-main'));
        $linkId = new IdAttribute('jump_to_content');
        $linkClass = new ClassAttribute(new BemPrefixed('nav-main', 'to-content'));
        $navMenuClass = new ClassAttribute(new BemPrefixed('nav-main', 'items'));

        $data = [
            'attributes' => [
                'id' => $id->value(),
                'class' => $class->value(),
            ],
            'link' => [
                'attributes' => [
                    'href' => apply_filters(self::FILTER_JUMP_TO_CONTENT_HREF, '#content'),
                    'id' => $linkId->value(),
                    'class' => $linkClass->value(),
                ],
                'label' => __('Jump To Content', 'wordpress-model'),
            ],
            'arguments' => [
                'theme_location' => $this->themeLocation,
                'menu_id' => $this->id,
                'container' => '',
                'depth' => $this->depth,
                'fallback_cb' => $this->fallback,
                'menu_class' => $navMenuClass->value(),
                'items_wrap' => '<ul class="%2$s">%3$s</ul>',
                'walker' => $this->walker,
            ],
        ];

        /**
         * Menu Data Filter
         *
         * @param array $menu The menu data view and wp_nav_menu args to filter.
         */
        $data = apply_filters(self::FILTER_DATA, $data);

        /**
         * Menu Data Filter By ID
         *
         * @param array $menu The menu data view and wp_nav_menu args to filter for a specific nav.
         */
        $data = apply_filters(self::FILTER_DATA . "_{$this->id}", $data);

        return $data;
    }

    /**
     * @return bool
     */
    private function hasNavMenu(): bool
    {
        return has_nav_menu($this->themeLocation);
    }
}
