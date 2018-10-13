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

use Widoz\Bem\Bem;
use Widoz\Bem\BemPrefixed;
use WordPressModel\Attribute\ClassAttribute;
use WordPressModel\Exception\InvalidAttachmentType;

/**
 * Attachment Image Model
 */
final class AttachmentImage implements Model
{
    const FILTER_DATA = 'wordpressmodel.figure';
    const FILTER_CAPTION = 'wordpressmodel.figure_caption';
    const FILTER_ALT = 'wordpressmodel.alt';

    /**
     * @var
     */
    private $attachmentSize;

    /**
     * @var int
     */
    private $attachmentId;

    /**
     * @var Bem
     */
    private $bem;

    /**
     * FigureImage constructor
     *
     * @param int $attachmentId
     * @param mixed $attachmentSize
     * @param Bem $bem
     *
     * phpcs:disable Inpsyde.CodeQuality.ArgumentTypeDeclaration.NoArgumentType
     */
    public function __construct(int $attachmentId, $attachmentSize, Bem $bem)
    {
        // phpcs:enable

        $this->attachmentId = $attachmentId;
        $this->attachmentSize = $attachmentSize;
        $this->bem = $bem;
    }

    /**
     * @return array
     */
    public function data(): array
    {
        $imageAttributeClass = new ClassAttribute(new BemPrefixed(
            $this->bem->block(),
            'image'
        ));

        /**
         * Figure Image Data
         *
         * @param array $data The data arguments for the template.
         */
        return apply_filters(self::FILTER_DATA, [
            'image' => [
                'attributes' => [
                    'url' => $this->attachmentUrl(),
                    'class' => $imageAttributeClass->value(),
                    'alt' => $this->alt(),
                ],
            ],
            'caption' => [
                'text' => $this->caption(),
                'attributes' => [
                    'class' => $this->bem->value(),
                ],
            ],
        ]);
    }

    /**
     * @return string
     *
     * @throws InvalidAttachmentType If the attachment isn't an image.
     */
    private function attachmentUrl(): string
    {
        if (wp_attachment_is_image($this->attachmentId)) {
            return wp_get_attachment_image_url($this->attachmentId, $this->attachmentSize);
        }

        throw new InvalidAttachmentType('Attachment must be an image.');
    }

    /**
     * @return string
     */
    private function caption(): string
    {
        $caption = (string)wp_get_attachment_caption($this->attachmentId);

        /**
         * Figure Image Caption Filter
         *
         * @param string $caption The caption for the image.
         * @param int $attachmentId The id of the attachment from which the caption is retrieved.
         */
        $caption = apply_filters(self::FILTER_CAPTION, $caption, $this->attachmentId);

        return (string)$caption;
    }

    /**
     * @return string
     */
    private function alt(): string
    {
        $alt = get_post_meta($this->attachmentId, '_wp_attachment_image_alt', true);

        /**
         * Filter Alt Attribute Value
         *
         * @param string $alt The alternative text.
         * @param int $attachmentId The id of the attachment from which the alt text is retrieved.
         */
        $alt = apply_filters(self::FILTER_ALT, $alt, $this->attachmentId);

        return (string)$alt;
    }
}
