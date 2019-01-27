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

use Widoz\Bem\Service as ServiceBem;
use WordPressModel\Attachment\Image\AlternativeText;
use WordPressModel\Attachment\Image\Source;

/**
 * Attachment Image Model
 */
final class AttachmentImage implements PartialModel
{
    public const FILTER_DATA = 'wordpressmodel.attachment_image';

    /**
     * @var ServiceBem
     */
    private $bem;

    /**
     * @var Source
     */
    private $attachmentImageSource;

    /**
     * @var AlternativeText
     */
    private $attachmentImageAltText;

    /**
     * AttachmentImage constructor
     * @param ServiceBem $bem
     * @param Source $attachmentImageSource
     * @param AlternativeText $attachmentImageAltText
     */
    public function __construct(
        ServiceBem $bem,
        Source $attachmentImageSource,
        AlternativeText $attachmentImageAltText
    ) {

        $this->bem = $bem;
        $this->attachmentImageSource = $attachmentImageSource;
        $this->attachmentImageAltText = $attachmentImageAltText;
    }

    /**
     * @return array
     */
    public function data(): array
    {
        /**
         * Figure Image Data
         *
         * @param array $data The data arguments for the template.
         */
        return apply_filters(self::FILTER_DATA, [
            'image' => [
                'attributes' => [
                    'url' => $this->attachmentImageSource->source,
                    'width' => $this->attachmentImageSource->width,
                    'height' => $this->attachmentImageSource->height,
                    'alt' => $this->attachmentImageAltText->text(),
                    'class' => $this->bem->forElement('image'),
                ],
            ],
        ]);
    }
}
