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

namespace WordPressModel\Model;

use InvalidArgumentException;
use Widoz\Bem\Service as BemService;
use WordPressModel\Exception\InvalidPostDateException;

/**
 * Post Published Date Model
 */
final class PostPublishedDate implements FullFilledModel
{
    public const FILTER_DATA = 'wordpressmodel.post_published_date';

    /**
     * @var BemService
     */
    private $bem;

    /**
     * @var DayArchiveLink
     */
    private $dayArchiveLink;

    /**
     * @var Time
     */
    private $time;

    /**
     * PostPublishedDate constructor.
     *
     * @param BemService $bem
     * @param DayArchiveLink $dayArchiveLink
     * @param Time $time
     */
    public function __construct(
        BemService $bem,
        DayArchiveLink $dayArchiveLink,
        Time $time
    ) {

        $this->bem = $bem;
        $this->dayArchiveLink = $dayArchiveLink;
        $this->time = $time;
    }

    /**
     * @inheritDoc
     * @throws InvalidArgumentException
     * @throws InvalidPostDateException
     */
    public function data(): array
    {
        /**
         * Post Published Data
         *
         * @param array $data The model.
         */
        return apply_filters(self::FILTER_DATA, [
            'container' => [
                'attributes' => [
                    'class' => $this->bem,
                ],
            ],
            'link' => $this->dayArchiveLink->data(),
            'time' => $this->time->data(),
        ]);
    }
}
