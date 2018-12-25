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

namespace WordPressModel;

use WordPressModel\Attribute\ClassAttribute;
use Widoz\Bem\BemPrefixed;

/**
 * Footer Colophon Model
 */
final class FooterColophon implements Model
{
    public const FILTER_DATA = 'wordpressmodel.footer_colophon';

    /**
     * @inheritdoc
     */
    public function data(): array
    {
        $classAttribute = new ClassAttribute(new BemPrefixed('footer', 'colophon'));

        /**
         * Footer Colophon Data
         *
         * @param array $data The data arguments for the template.
         */
        return apply_filters(self::FILTER_DATA, [
            'container' => [
                'attributes' => [
                    'class' => $classAttribute->value(),
                ],
            ],
            'markup' => $this->content(),
        ]);
    }

    /**
     * @return string
     */
    private function content(): string
    {
        $theme = $this->theme();

        return sprintf(
            // translators: The %s are the links to WordPress and WordPress Theme Model homepages
            __('Proudly by %1$s - Theme Name: %2$s', 'wordpress-model'),
            '<a href="https://www.wordpress.org">' . __('WordPress', 'wordpress-model') . '</a>',
            '<a href="' . esc_url($theme->get('ThemeURI')) . '">' . $theme->get('Name') . '</a>'
        );
    }

    /**
     * @return \WP_Theme
     */
    private function theme(): \WP_Theme
    {
        static $theme = null;

        if ($theme !== null) {
            return $theme;
        }

        return wp_get_theme();
    }
}
