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

namespace WordPressModel;

/**
 * Class Model
 */
interface Model
{
    /**
     * Data
     *
     * @return array The list of elements to bind in the view
     */
    public function data(): array;
}
