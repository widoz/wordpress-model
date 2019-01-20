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
use Widoz\Bem\Service as ServiceBem;

/**
 * Header Background Model
 */
final class HeaderBackground implements FullFilledModel, NeedAsset
{
    public const FILTER_DATA = 'wordpressmodel.header_background';

    /**
     * @inheritdoc
     */
    public function data(): array
    {
        if (!$this->canBeShowed()) {
            return [];
        }

        $bem = Factory::createServiceForStandard('header-thumbnail');

        /**
         * Header Background Data
         *
         * @param array $data The data arguments for the template.
         */
        return apply_filters(self::FILTER_DATA, [
            'container' => [
                'attributes' => [
                    'class' => $bem,
                ],
            ],
            'markup' => $this->hasVideo() ? get_custom_header_markup() : '',
            'image' => [
                'markup' => $this->hasImage() ? $this->headerImageMarkup($bem) : '',
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function requireAsset(): void
    {
        if ($this->hasVideo() && wp_script_is('wp-custom-header', 'registered')) {
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

    /**
     * @return string The header image markup
     */
    private function headerImageMarkup(ServiceBem $bem): string
    {
        return get_header_image_tag([
            'class' => $bem->forElement('image'),
        ]);
    }
}
