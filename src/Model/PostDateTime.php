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

use WordPressModel\Exception\DateTimeException;
use WordPressModel\Factory\PostDateTime\PostDateTimeFactory;
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
     * @var PostDateTimeFactory
     */
    private $dateTimeFactory;

    /**
     * @var WP_Post
     */
    private $post;

    /**
     * Time constructor
     *
     * @param WP_Post $post
     * @param PostDateTimeFactory $postDateTimeFactory
     */
    public function __construct(WP_Post $post, PostDateTimeFactory $postDateTimeFactory)
    {
        $this->dateTimeFactory = $postDateTimeFactory;
        $this->post = $post;
    }

    /**
     * @inheritDoc
     */
    public function data(): array
    {
        try {
            $dateTime = $this->dateTimeFactory->create($this->post, 'created');
        } catch (DateTimeException $exc) {
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
                'content' => $dateTime->format('Y/m/d'),
                'attributes' => [
                    'datetime' => $dateTime->format('l, F j, Y g:i a'),
                ],
            ]
        );
    }
}
