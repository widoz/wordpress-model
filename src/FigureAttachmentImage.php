<?php # -*- coding: utf-8 -*-

/*
 * This file is part of the wordpress-model package.
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

/**
 * Class FigureAttachmentImage
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class FigureAttachmentImage implements Model
{
    public const FILTER_DATA = 'wordpressmodel.figure_attachment_image';
    public const FILTER_CAPTION = 'wordpressmodel.figcaption';

    /**
     * @var mixed
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
        $figureAttributeClass = new ClassAttribute($this->bem);
        $captionAttributeClass = new ClassAttribute(new BemPrefixed(
            $this->bem->block(),
            'caption'
        ));

        return apply_filters(
            self::FILTER_DATA,
            [
                'figure' => [
                    'attributes' => [
                        'class' => $figureAttributeClass->value(),
                    ],
                ],
                'figcaption' => [
                    'text' => $this->caption(),
                    'attributes' => [
                        'class' => $captionAttributeClass->value(),
                    ],
                ],
            ] + $this->attachmentModel()->data()
        );
    }

    /**
     * @return AttachmentImage
     */
    private function attachmentModel(): AttachmentImage
    {
        $attachmentImage = new AttachmentImage(
            $this->attachmentId,
            $this->attachmentSize,
            $this->bem
        );

        return $attachmentImage;
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
}
