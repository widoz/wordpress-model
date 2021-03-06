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

use InvalidArgumentException;
use Widoz\Bem\Service as ServiceBem;
use WordPressModel\Attachment\Image\AlternativeText;
use WordPressModel\Attachment\Image\Source;
use WP_Post;

/**
 * Attachment Image Model
 */
class AttachmentImage implements PartialModel
{
    public const FILTER_DATA = 'wordpressmodel.attachment_image';

    /**
     * @var ServiceBem
     */
    private $bem;

    /**
     * @var Source
     */
    private $attachImageSource;

    /**
     * @var AlternativeText
     */
    private $attachImageAltText;

    /**
     * @var WP_Post
     */
    private $attachment;

    /**
     * AttachmentImage constructor
     * @param ServiceBem $bem
     * @param WP_Post $attachment
     * @param Source $attachmentImageSource
     * @param AlternativeText $attachmentImageAltText
     */
    public function __construct(
        ServiceBem $bem,
        WP_Post $attachment,
        Source $attachmentImageSource,
        AlternativeText $attachmentImageAltText
    ) {

        $this->bem = $bem;
        $this->attachment = $attachment;
        $this->attachImageSource = $attachmentImageSource;
        $this->attachImageAltText = $attachmentImageAltText;
    }

    /**
     * @return array
     * @throws InvalidArgumentException
     */
    public function data(): array
    {
        /**
         * Attachment Image Data
         *
         * @param array $data The data arguments for the template.
         */
        return apply_filters(self::FILTER_DATA, [
            'attributes' => [
                'src' => $this->attachImageSource->source(),
                'width' => $this->attachImageSource->width(),
                'height' => $this->attachImageSource->height(),
                'alt' => $this->attachImageAltText->__invoke($this->attachment),
                'class' => $this->bem->forElement('image'),
            ],
        ]);
    }
}
