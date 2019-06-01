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

namespace WordPressModel\Factory;

use DateTimeZone;

/**
 * Interface DateTimeZoneFactory
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
interface DateTimeZoneFactory
{
    /**
     * @return DateTimeZone
     */
    public function create(): DateTimeZone;
}
