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
use function in_array;
use function is_numeric;

/**
 * Class WpTimeZoneFactory
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class WpDateTimeZoneFactory implements DateTimeZoneFactory
{
    /**
     * @inheritDoc
     */
    public function create(): DateTimeZone
    {
        // Timezone_string is empty when the option is set to Manual Offset. So we use gmt_offset.
        $option = get_option('timezone_string') ?: get_option('gmt_offset');
        // Set to UTC in order to prevent issue if used with DateTimeZone constructor.
        $option = (in_array($option, ['', '0'], true) ? 'UTC' : $option);
        // And remember to add the symbol.
        if (is_numeric($option)) {
            $option = $this->normalizeOffset($option);
        }

        return new DateTimeZone($option);
    }

    /**
     * Normalize the Offset
     *
     * @param string $offset
     * @return string
     */
    protected function normalizeOffset(string $offset): string
    {
        $offset = (float)$offset;
        $offset = 0 < $offset ? "+{$offset}" : $offset;
        $offset = (string)$offset;

        return $offset;
    }
}
