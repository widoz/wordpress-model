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

/**
 * Attachment Image Size
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class Size
{
    /**
     * @var array
     */
    private $sizes;

    /**
     * AttachmentImageSize constructor
     * @param int|string[] $sizes
     */
    public function __construct(...$sizes)
    {
        $this->sizes = $sizes;
    }

    /**
     * @return array|string
     * @throws \InvalidArgumentException If size is empty
     * @throws \LengthException If size contains more than 2 values
     * @throws \DomainException If size is an array with 2 elements but one of them isn't an integer
     */
    public function value()
    {
        if (!$this->sizes) {
            throw new \InvalidArgumentException('Size cannot be an empty array');
        }
        if (count($this->sizes) > 2) {
            throw new \LengthException('Size cannot contains more than 2 elements');
        }

        if (count($this->sizes) === 1) {
            $size = $this->sizes[0];

            return \is_numeric($size) ? $this->toInteger($size, $size) : (string)$size;
        }

        /** @noinspection UnqualifiedReferenceInspection */
        $sizes = \array_filter($this->sizes, 'is_numeric');

        if (count($sizes) !== 2) {
            throw new \DomainException('All sizes values must be numeric');
        }

        return $this->toInteger(...$sizes);
    }

    /**
     * @param mixed ...$numbers
     * @return int[]
     */
    private function toInteger(...$numbers): array
    {
        /** @noinspection UnqualifiedReferenceInspection */
        return \array_map('intval', $numbers);
    }
}
