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
use WordPressModel\Utils\ImplodeArray;

/**
 * Brand Model
 */
final class Brand implements FullFilledModel
{
    public const FILTER_DATA = 'wordpressmodel.brand_logo';

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
            /**
             * Filter Data
             *
             * @param array $data The data for the template to filter.
             */
            return apply_filters(self::FILTER_DATA, []);
        }

        $bem = Factory::createServiceForStandard('brand');
        $attachmentId = $this->attachmentId();
        $style = $this->style([
            'color' => $this->headerTextColor(),
        ]);
        $attachmentModel = $this->attachmentModel($bem, $attachmentId);

        $data = [
            'container' => [
                'attributes' => [
                    'class' => $bem,
                ],
            ],
            'name' => [
                'text' => get_bloginfo('name'),
            ],
            'link' => [
                'attributes' => [
                    'href' => $this->siteUrl(),
                    'class' => $bem->forElement('link'),
                    'style' => $style,
                ],
            ],
            'description' => [
                'text' => get_bloginfo('description'),
                'attributes' => [
                    'class' => $bem->forElement('description'),
                ],
            ],
        ];

        /** @noinspection AdditionOperationOnArraysInspection */
        $attachmentId and $data += $attachmentModel->data();

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
        return (bool)trim(get_bloginfo('name'));
    }

    /**
     * @param ServiceBem $bemService
     * @param int $attachmentId
     * @return AttachmentImage
     *
     * phpcs:disable Inpsyde.CodeQuality.ArgumentTypeDeclaration.NoArgumentType
     */
    private function attachmentModel(ServiceBem $bemService, int $attachmentId): AttachmentImage
    {
        // phpcs:enable

        return new AttachmentImage(
            $bemService,
            $attachmentId,
            $this->attachmentSize
        );
    }

    /**
     * @param array $attributes
     * @return string
     */
    private function style(array $attributes): string
    {
        $implode = new ImplodeArray($attributes);

        return $implode->forAttributeStyle();
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
