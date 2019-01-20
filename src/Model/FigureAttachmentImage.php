<?php # -*- coding: utf-8 -*-

/*
 * This file is part of the WordPress Model package.
 *
 * (c) Guido Scialfa <dev@guidoscialfa.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace WordPressModel\Model;

use Widoz\Bem\Service as ServiceBem;

/**
 * Class FigureAttachmentImage
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class FigureAttachmentImage implements PartialModel
{
    public const FILTER_DATA = 'wordpressmodel.figure_attachment_image';
    public const FILTER_CAPTION = 'wordpressmodel.figcaption';

    /**
     * @var ServiceBem
     */
    private $bem;

    /**
     * @var mixed
     */
    private $attachmentSize;

    /**
     * @var int
     */
    private $attachmentId;

    /**
     * FigureImage constructor
     *
     * @param int $attachmentId
     * @param mixed $attachmentSize
     * @param ServiceBem $bem
     *
     * phpcs:disable Inpsyde.CodeQuality.ArgumentTypeDeclaration.NoArgumentType
     */
    public function __construct(ServiceBem $bem, int $attachmentId, $attachmentSize)
    {
        // phpcs:enable

        $this->bem = $bem;
        $this->attachmentId = $attachmentId;
        $this->attachmentSize = $attachmentSize;
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return apply_filters(
            self::FILTER_DATA,
            [
                'figure' => [
                    'attributes' => [
                        'class' => $this->bem->forElement('figure'),
                    ],
                ],
                'figcaption' => [
                    'text' => $this->caption(),
                    'attributes' => [
                        'class' => $this->bem->forElement('caption'),
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
            $this->bem,
            $this->attachmentId,
            $this->attachmentSize
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
