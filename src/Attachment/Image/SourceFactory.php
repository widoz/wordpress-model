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

namespace WordPressModel\Attachment\Image;

use WP_Post;
use InvalidArgumentException;

/**
 * Class SourceFactory
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class SourceFactory
{
    /**
     * Create an Instance of Source by the Given Attachment Post and Size
     *
     * @param WP_Post $attachment
     * @param Size $size
     * @return Source
     * @throws InvalidArgumentException
     * @throws \DomainException
     * @throws \LengthException
     */
    public function create(WP_Post $attachment, Size $size): Source
    {
        if (!\wp_attachment_is_image($attachment)) {
            throw new InvalidArgumentException('Attachment must be an image.');
        }

        $imageSource = (array)\wp_get_attachment_image_src($attachment->ID, $size->value());
        $imageSource = \array_filter($imageSource);

        if (!$imageSource) {
            throw new \DomainException(
                \sprintf('Image with ID: %d, no longer exists', $attachment->ID)
            );
        }

        return new Source(...$imageSource);
    }
}
