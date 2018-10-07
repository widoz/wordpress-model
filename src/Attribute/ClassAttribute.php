<?php # -*- coding: utf-8 -*-

/*
 * This file is part of the WordPress Theme Model Theme package.
 *
 * (c) Guido Scialfa <dev@guidoscialfa.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace WordPressModel\Attribute;

use Widoz\Bem\Bem;

/**
 * Class Attribute
 */
final class ClassAttribute implements Attribute
{
    /**
     * @var Bem The bem instance
     */
    private $bem;

    /**
     * ClassAttribute constructor
     *
     * @param Bem $bem The value instance.
     */
    public function __construct(Bem $bem)
    {
        $this->bem = $bem;
    }

    /**
     * @inheritdoc
     */
    public function value(): string
    {
        return $this->bem->value();
    }

    /**
     * @inheritdoc
     *
     * phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped
     */
    public function __toString(): string
    {
        return 'class="' . sanitize_html_class($this->bem) . '"';

        // phpcs:enable
    }
}
