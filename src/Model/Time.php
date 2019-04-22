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

use WordPressModel\Exception\InvalidPostDateException;
use WP_Post;

/**
 * Class Time
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class Time implements Model
{
    public const FILTER_DATA = 'wordpressmodel.time';

    /**
     * @var PostDateTime
     */
    private $postDateTime;

    /**
     * @var WP_Post
     */
    private $post;

    /**
     * @var string
     */
    private $dateTimeFormat;

    public function __construct(WP_Post $post, PostDateTime $postDateTime, string $dateTimeFormat)
    {
        $this->postDateTime = $postDateTime;
        $this->post = $post;
        $this->dateTimeFormat = $dateTimeFormat;
    }

    public function data(): array
    {
        try {
            $postDateTime = $this->postDateTime->date($this->post, $this->dateTimeFormat);
            $timeValue = $this->postDateTime->date($this->post, 'l, F j, Y g:i a');
        } catch (InvalidPostDateException $exc) {
            $postDateTime = '';
            $timeValue = '';
        }

        if (!$postDateTime || !$timeValue) {
            return [];
        }

        /**
         * Filter Data
         *
         * @param array $data The data model
         */
        return apply_filters(self::FILTER_DATA, [
            'text' => $timeValue,
            'attributes' => [
                'datetime' => $postDateTime,
            ],
        ]);
    }
}
