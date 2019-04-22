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
use WordPressModel\Utils\Assert;
use WP_Post;

/**
 * Post Published Date Model
 */
final class PostPublishedDate implements FullFilledModel
{
    public const FILTER_DATA = 'wordpressmodel.post_published_date';

    /**
     * @var WP_Post
     */
    private $post;

    /**
     * @var BemService
     */
    private $bem;

    /**
     * @var PostDateTime
     */
    private $postDateTime;

    /**
     * @var string
     */
    private $dateTimeFormat;

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
     * @param WP_Post $post
     * @param DayArchiveLink $dayArchiveLink
     * @param PostDateTime $postDateTime
     * @param Time $time
     * @param string $dateTimeFormat
     */
    public function __construct(
        BemService $bem,
        WP_Post $post,
        DayArchiveLink $dayArchiveLink,
        PostDateTime $postDateTime,
        Time $time,
        string $dateTimeFormat
    ) {

        Assert::stringNotEmpty($dateTimeFormat);

        $this->bem = $bem;
        $this->post = $post;
        $this->dayArchiveLink = $dayArchiveLink;
        $this->postDateTime = $postDateTime;
        $this->time = $time;
        $this->dateTimeFormat = $dateTimeFormat;
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
