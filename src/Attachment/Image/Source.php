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

use function file_exists;
use \InvalidArgumentException;

/**
 * Attachment Image Source
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class Source
{
    /**
     * @var string
     */
    private $source;

    /**
     * @var int
     */
    private $width;

    /**
     * @var int
     */
    private $height;

    /**
     * @var bool
     */
    private $intermediate;

    /**
     * Source constructor
     *
     * @param string $source
     * @param int $width
     * @param int $height
     * @param bool $intermediate
     * @throws InvalidArgumentException
     */
    public function __construct(string $source, int $width, int $height, bool $intermediate)
    {
        $this->bailIfConstructArguments($source, $width, $height);

        $this->source = $source;
        $this->width = $width;
        $this->height = $height;
        $this->intermediate = $intermediate;
    }

    /**
     * @return string
     */
    public function source(): string
    {
        return $this->source;
    }

    /**
     * @return int
     */
    public function width(): int
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function height(): int
    {
        return $this->height;
    }

    /**
     * @return bool
     */
    public function intermediate(): bool
    {
        return $this->intermediate;
    }

    /**
     * Validate Arguments for Constructor
     *
     * @param string $source
     * @param int $width
     * @param int $height
     * @throws InvalidArgumentException
     */
    private function bailIfConstructArguments(string $source, int $width, int $height): void
    {
        if ($width <= 0) {
            throw new InvalidArgumentException('Width cannot be less or equal than zero.');
        }
        if ($height <= 0) {
            throw new InvalidArgumentException('Height cannot be less or equal than zero.');
        }
        if (!file_exists($source)) {
            throw new InvalidArgumentException('Source file does not exists.');
        }
    }
}
