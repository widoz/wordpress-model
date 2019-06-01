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

namespace WordPressModel\Exception;

use Exception;

/**
 * Class DateTimeException
 *
 * DateTime Classes Returns an Exception that it's too generic.
 * This class will allow a better catch flow.
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class DateTimeException extends Exception
{
    /**
     * Create From Exception
     *
     * @param Exception $exc
     * @return DateTimeException
     */
    public static function fromException(Exception $exc): self
    {
        return new self(
            $exc->getMessage(),
            $exc->getCode(),
            $exc->getPrevious()
        );
    }
}
