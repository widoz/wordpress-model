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

/**
 * Main Nav Menu Model
 */
final class MainNavMenu implements FullFilledModel
{
    public const FILTER_DATA = 'wordpressmodel.main_nav_menu';
    public const FILTER_JUMP_TO_CONTENT_HREF = 'wordpressmodel.menu_jump_to_content_href';

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
     *
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
        $data = [];

        if ($this->hasNavMenu()) {
            $bem = Factory::createServiceForStandard('nav-main');
            $data = [
                'container' => [
                    'attributes' => [
                        'id' => 'main-menu',
                        'class' => $bem,
                    ],
                ],
                'link' => [
                    'text' => __('Jump To Content', 'wordpress-model'),
                    'attributes' => [
                        'href' => apply_filters(self::FILTER_JUMP_TO_CONTENT_HREF, '#content'),
                        'id' => 'jump_to_content',
                        'class' => $bem->forElement('to-content'),
                    ],
                ],
                'arguments' => [
                    'theme_location' => $this->themeLocation,
                    'menu_id' => $this->id,
                    'container' => '',
                    'depth' => $this->depth,
                    'fallback_cb' => $this->fallback,
                    'menu_class' => $bem->forElement('items'),
                    'items_wrap' => '<ul class="%2$s">%3$s</ul>',
                    'walker' => $this->walker,
                ],
            ];
        }

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
