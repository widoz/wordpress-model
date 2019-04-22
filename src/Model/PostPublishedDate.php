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
     * PostPublishedDate constructor.
     *
     * @param BemService $bem
     * @param WP_Post $post
     * @param DayArchiveLink $dayArchiveLink
     * @param PostDateTime $postDateTime
     * @param string $dateTimeFormat
     */
    public function __construct(
        BemService $bem,
        WP_Post $post,
        DayArchiveLink $dayArchiveLink,
        PostDateTime $postDateTime,
        string $dateTimeFormat
    ) {

        Assert::stringNotEmpty($dateTimeFormat);

        $this->post = $post;
        $this->bem = $bem;
        $this->postDateTime = $postDateTime;
        $this->dateTimeFormat = $dateTimeFormat;
        $this->dayArchiveLink = $dayArchiveLink;
    }

    /**
     * @inheritDoc
     * @throws InvalidArgumentException
     * @throws InvalidPostDateException
     */
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
            'time' => [
                'value' => $timeValue,
                'attributes' => [
                    'datetime' => $postDateTime,
                ],
            ],
        ]);
    }
}
