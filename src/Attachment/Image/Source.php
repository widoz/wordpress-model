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

namespace WordPressModel\Attachment\Image;

use WordPressModel\Exception\InvalidAttachmentType;

/**
 * Attachment Image Source
 *
 * @property $source
 * @property $width
 * @property $height
 * @property $intermediate
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class Source
{
    /**
     * @var string
     */
    private $source = '';

    /**
     * @var int
     */
    private $width = 0;

    /**
     * @var int
     */
    private $height = 0;

    /**
     * @var bool
     */
    private $intermediate = false;

    /**
     * AttachmentImageSource constructor
     * @param \WP_Post $attachment
     * @param Size $size
     */
    public function __construct(\WP_Post $attachment, Size $size)
    {
        $this->attachmentImageSource($attachment, $size);
    }

    /**
     * @param string $name
     * @return bool
     */
    public function __isset(string $name): bool
    {
        return isset($this->{$name});
    }

    /**
     * @param string $name
     * @param $value
     * @throws \BadMethodCallException
     */
    public function __set(string $name, $value)
    {
        throw new \BadMethodCallException(
            'Properties of class AttachmentImageSource cannot be set.'
        );
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __get(string $name)
    {
        return $this->{$name};
    }

    /**
     * @param \WP_Post $attachment
     * @param Size $size
     * @throws \DomainException
     */
    private function attachmentImageSource(\WP_Post $attachment, Size $size): void
    {
        $this->ensureAttachmentIsImage($attachment);

        $imageSource = (array)wp_get_attachment_image_src($attachment->ID, $size->value());
        $imageSource = array_filter($imageSource);

        if (!$imageSource) {
            throw new \DomainException(
                sprintf('Image with ID: %d, no longer exists', $attachment->ID)
            );
        }

        $this->source = $imageSource[0];
        $this->width = $imageSource[1];
        $this->height = $imageSource[2];
        $this->intermediate = $imageSource[3] ?? false;
    }

    /**
     * @param \WP_Post $attachment
     * @throws InvalidAttachmentType
     */
    private function ensureAttachmentIsImage(\WP_Post $attachment): void
    {
        if (!wp_attachment_is_image($attachment)) {
            throw new InvalidAttachmentType('Attachment must be a type of image.');
        }
    }
}
