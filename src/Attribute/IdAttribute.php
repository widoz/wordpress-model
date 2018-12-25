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

namespace WordPressModel\Attribute;

/**
 * Id Attribute
 */
final class IdAttribute implements Attribute
{
    /**
     * @var string The string value for the attribute
     */
    private $id;

    /**
     * @var string The value prefix
     */
    private $prefix;

    /**
     * ClassAttribute constructor
     *
     * @param string $id The id value string for the attribute.
     * @param string $prefix The value prefix.
     */
    public function __construct(string $id, string $prefix = '')
    {
        $this->id = $id;
        $this->prefix = $prefix;
    }

    /**
     * @inheritdoc
     */
    public function value(): string
    {
        return $this->prefix . $this->id;
    }

    /**
     * @inheritdoc
     */
    public function __toString(): string
    {
        return 'id="' . sanitize_html_class($this->value()) . '"';
    }
}
