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
use WordPressModel\Utils\ImplodeArray;
use Widoz\Bem\BemPrefixed;
use Widoz\Bem\Bem;

/**
 * Brand Model
 */
final class Brand implements Model
{
    private const FILTER_DATA = 'wordpressmodel.brandlogo';

    /**
     * @var array|string
     */
    private $attachmentSize;

    /**
     * Brand constructor.
     *
     * @param $attachmentSize
     *
     * phpcs:disable Inpsyde.CodeQuality.ArgumentTypeDeclaration.NoArgumentType
     */
    public function __construct($attachmentSize)
    {
        // phpcs:enable

        $this->attachmentSize = $attachmentSize;
    }

    /**
     * @return array
     *
     * @todo Get rid of Figure and use custom logo without the anchor tag?
     */
    public function data(): array
    {
        if (!$this->mayBeDisplayed()) {
            return [];
        }

        $attachmentId = $this->attachmentId();
        $style = $this->style([
            'color' => $this->headerTextColor(),
        ]);

        $class = new ClassAttribute(new BemPrefixed('brand'));
        $linkClass = new ClassAttribute(new BemPrefixed('brand', 'link'));
        $descriptionClass = new ClassAttribute(new BemPrefixed('brand', 'description'));

        $attachmentModel = $this->attachmentModel(new BemPrefixed('brand-logo'), $attachmentId);

        /**
         * Filter Data
         *
         * @param array $data The data for the template to filter.
         */
        return apply_filters(self::FILTER_DATA, [
            'container' => [
                'name' => get_bloginfo('name'),
                'attributes' => [
                    'class' => $class->value(),
                ],
            ],
            'link' => [
                'attributes' => [
                    'href' => $this->siteUrl(),
                    'class' => $linkClass->value(),
                    'style' => $style,
                ],
            ],
            'description' => [
                'text' => get_bloginfo('description'),
                'attributes' => [
                    'class' => $descriptionClass->value(),
                ],
            ],
            'figure' => $attachmentId
                ? $attachmentModel->data()
                : [],
        ]);
    }

    /**
     * @return bool
     */
    private function mayBeDisplayed(): bool
    {
        return (bool)trim(get_bloginfo('name'));
    }

    /**
     * @param Bem $bem
     * @param int $attachmentId
     * @return AttachmentImage
     *
     * phpcs:disable Inpsyde.CodeQuality.ArgumentTypeDeclaration.NoArgumentType
     */
    private function attachmentModel(Bem $bem, int $attachmentId): AttachmentImage
    {
        // phpcs:enable

        return new AttachmentImage(
            $attachmentId,
            $this->attachmentSize,
            $bem
        );
    }

    /**
     * @param array $attributes
     * @return string
     */
    private function style(array $attributes): string
    {
        $implode = new ImplodeArray($attributes);
        $value = $implode->forAttributeStyle();

        return $value;
    }

    /**
     * @return string
     */
    private function headerTextColor(): string
    {
        return '#' . sanitize_hex_color_no_hash(get_header_textcolor());
    }

    /**
     * @return string
     */
    private function siteUrl(): string
    {
        return home_url('/');
    }

    /**
     * @return int
     */
    private function attachmentId(): int
    {
        return (int)get_theme_mod('custom_logo', 0);
    }
}
