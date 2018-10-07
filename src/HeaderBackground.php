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
 * Header Background Model
 */
final class HeaderBackground implements Model, NeedAsset
{
    private const FILTER_DATA = 'wordpressmodel.template_data_header_background';

    /**
     * @inheritdoc
     */
    public function data(): array
    {
        if (! $this->canBeShowed()) {
            return [];
        }

        /**
         * Header Background Data
         *
         * @param array $data The data arguments for the template.
         */
        return apply_filters(self::FILTER_DATA, [
            'video' => $this->hasVideo() ? get_custom_header_markup() : '',
            'attributes' => [
                'class' => (new BemPrefixed('header-thumbnail'))->value(),
            ],
            'link' => [
                'attributes' => [
                    'href' => home_url('/'),
                    'class' => (new BemPrefixed('header-thumbnail', 'link'))->value(),
                ],
            ],
            'image' => $this->hasImage() ? get_header_image_tag([
                'class' => (new BemPrefixed('header-thumbnail', 'image'))->value(),
            ]) : '',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function requireAsset(): void
    {
        if ($this->hasVideo() and wp_script_is('wp_custom-header', 'registered')) {
            wp_enqueue_script('wp-custom-header');
            wp_localize_script(
                'wp-custom-header',
                '_wpCustomHeaderSettings',
                get_header_video_settings()
            );
        }
    }

    /**
     * @return bool True if the header background can be showed on page, false otherwise
     */
    private function canBeShowed(): bool
    {
        return $this->hasSupport() && ($this->hasVideo() || $this->hasImage());
    }

    /**
     * @return bool True if theme has support for custom background, false otherwise
     */
    private function hasSupport(): bool
    {
        return current_theme_supports('custom-header');
    }

    /**
     * @return bool True if video is set and valid to be showed, false otherwise
     */
    private function hasVideo(): bool
    {
        return is_header_video_active() && has_header_video();
    }

    /**
     * @return bool True if header background has image set
     */
    private function hasImage(): bool
    {
        return has_header_image();
    }
}
