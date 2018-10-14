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
    public const FILTER_DATA = 'wordpressmodel.attachment_image';
    public const FILTER_ALT = 'wordpressmodel.attachment_image_alt';

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
     * TODO Use \WP_Post instead of an attachment id
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
