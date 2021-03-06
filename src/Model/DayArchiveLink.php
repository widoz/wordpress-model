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

use function explode;
use function get_day_link;
use InvalidArgumentException;
use Widoz\Bem\Service as BemService;
use WordPressModel\Exception\DateTimeException;
use WordPressModel\Factory\PostDateTime\CreatedDateTimeFactory;
use WordPressModel\Exception\InvalidPostDateTimeException;
use WordPressModel\Factory\PostDateTime\PostDateTimeFactory;
use WordPressModel\Utils\Assert;
use WP_Post;

/**
 * Class DayArchiveLink
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class DayArchiveLink implements Model
{
    public const FILTER_DATA = 'wordpressmodel.date_archive_link';

    /**
     * @var WP_Post
     */
    private $post;

    /**
     * @var BemService
     */
    private $bem;

    /**
     * @var string
     */
    private $text;

    /**
     * @var PostDateTimeFactory
     */
    private $postDateTimeFactory;

    /**
     * DayArchiveLink constructor
     * @param BemService $bem
     * @param WP_Post $post
     * @param string $text
     * @param PostDateTimeFactory $postDateTimeFactory
     */
    public function __construct(
        BemService $bem,
        WP_Post $post,
        string $text,
        PostDateTimeFactory $postDateTimeFactory
    ) {

        Assert::stringNotEmpty($text);

        $this->post = $post;
        $this->bem = $bem;
        $this->text = $text;
        $this->postDateTimeFactory = $postDateTimeFactory;
    }

    /**
     * @inheritDoc
     * @throws InvalidArgumentException
     * @throws InvalidPostDateTimeException
     */
    public function data(): array
    {
        $archiveLink = '';

        try {
            $linkDateTime = $this->postDateTimeFactory->create($this->post, 'created');
            $linkDate = $linkDateTime->format('Y m d');
            $linkDate = explode(' ', $linkDate);
        } catch (DateTimeException $exc) {
            $linkDate = null;
        }

        $linkDate and $archiveLink = get_day_link(...$linkDate);

        if (!$archiveLink) {
            return [];
        }

        /**
         * Day Archive Link
         *
         * @param array $data The model.
         */
        return apply_filters(self::FILTER_DATA, [
            'content' => $this->text,
            'attributes' => [
                'href' => $archiveLink,
                'class' => $this->bem->forElement('link'),
            ],
        ]);
    }
}
