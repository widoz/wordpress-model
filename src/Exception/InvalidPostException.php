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

namespace WordPressModel\Exception;

/**
 * Invalid Post Exception
 */
class InvalidPostException extends PostException
{
    /**
     * InvalidPostException constructor
     */
    public function __construct()
    {
        parent::__construct(
            sprintf(
                '%s cannot retrieve post.',
                $this->getCaller()
            )
        );
    }
}
