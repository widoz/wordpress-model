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

namespace WordPressModel\Model;

use InvalidArgumentException;
use WordPressModel\Factory\PostDateTime\CreatedDateTimeFactory;
use WordPressModel\Exception\InvalidPostDateTimeException;
use WP_Post;

/**
 * Class PostDateTime
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class PostDateTime implements Model
{
    public const FILTER_DATA = 'wordpressmodel.time';

    /**
     * @var CreatedDateTimeFactory
     */
    private $dateTime;

    /**
     * @var WP_Post
     */
    private $post;

    /**
     * @var string
     */
    private $dateTimeFormat;

    /**
     * Time constructor
     * @param WP_Post $post
     * @param CreatedDateTimeFactory $dateTime
     * @param string $dateTimeFormat
     */
    public function __construct(
        WP_Post $post,
        CreatedDateTimeFactory $dateTime,
        string $dateTimeFormat
    ) {

        $this->dateTime = $dateTime;
        $this->post = $post;
        $this->dateTimeFormat = $dateTimeFormat;
    }

    /**
     * @inheritDoc
     * @throws InvalidArgumentException
     */
    public function data(): array
    {
        try {
            $dateTime = $this->dateTime->date($this->post, $this->dateTimeFormat);
            $timeValue = $this->dateTime->date($this->post, 'l, F j, Y g:i a');
        } catch (InvalidPostDateTimeException $exc) {
            $dateTime = '';
            $timeValue = '';
        }

        if (!$dateTime || !$timeValue) {
            return [];
        }

        /**
         * Filter Data
         *
         * @param array $data The data model
         */
        return apply_filters(
            self::FILTER_DATA,
            [
                'content' => $timeValue,
                'attributes' => [
                    'datetime' => $dateTime,
                ],
            ]
        );
    }
}
