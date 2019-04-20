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

use InvalidArgumentException;
use WordPressModel\Utils\Assert;

/**
 * Attachment Image Size
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class Size
{
    /**
     * @var int
     */
    private $width;

    /**
     * @var int
     */
    private $height;

    /**
     * Create a Size Instance by string WordPress style
     *
     * @param string $name
     * @return Size
     * @throws InvalidArgumentException
     */
    public static function createBySizeName(string $name): self
    {
        $registeredWordPressImageSizes = \get_intermediate_image_sizes();
        $additionalImageSizes = \wp_get_additional_image_sizes();

        Assert::oneOf(
            $name,
            $registeredWordPressImageSizes,
            "{$name} size not found on WordPress registered sizes."
        );

        if ($additionalImageSizes[$name] ?? false) {
            return new self(
                (int)$additionalImageSizes[$name]['width'],
                (int)$additionalImageSizes[$name]['height']
            );
        }

        return new self(
            (int)get_option("{$name}_size_w", null),
            (int)get_option("{$name}_size_h", null)
        );
    }

    /**
     * Create a Size Instance by Width and Height values
     *
     * @param int $width
     * @param int $height
     * @return Size
     * @throws InvalidArgumentException
     */
    public static function createByValues(int $width, int $height): self
    {
        return new self($width, $height);
    }

    /**
     * Retrieve the Width
     *
     * @return int
     */
    public function width(): int
    {
        return $this->width;
    }

    /**
     * Retrieve the Height
     *
     * @return int
     */
    public function height(): int
    {
        return $this->height;
    }

    /**
     * Size constructor
     * @param int $width
     * @param int $height
     * @throws InvalidArgumentException
     */
    private function __construct(int $width, int $height)
    {
        $sizes = \array_filter([$width, $height], function (int $value): bool {
            return $value > 0;
        });

        Assert::count($sizes, 2, 'Width and Height must be greater than zero');

        [$this->width, $this->height] = $sizes;
    }
}
