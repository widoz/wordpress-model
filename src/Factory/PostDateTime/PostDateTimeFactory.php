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

namespace WordPressModel\Factory\PostDateTime;

use DateTimeInterface;
use InvalidArgumentException;
use WordPressModel\Exception\DateTimeException;
use WordPressModel\Exception\InvalidPostDateTimeException;
use WordPressModel\Factory\DateTimeZoneFactory;
use WP_Post;

/**
 * Class PostDateTimeFactory
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class PostDateTimeFactory
{
    /**
     * @var DateTimeZoneFactory
     */
    private $timeZoneFactory;

    /**
     * @var DateTimeFormat
     */
    private $dateTimeFormat;

    /**
     * @var ModifiedDateTimeFactory
     */
    private $modifiedDateTimeFactory;

    /**
     * @var CreatedDateTimeFactory
     */
    private $createdDateTimeFactory;

    /**
     * PostDateTimeFactory constructor
     * @param DateTimeZoneFactory $timeZoneFactory
     * @param DateTimeFormat $dateTimeFormat
     * @param ModifiedDateTimeFactory $modifiedDateTimeFactory
     * @param CreatedDateTimeFactory $createdDateTimeFactory
     */
    public function __construct(
        DateTimeZoneFactory $timeZoneFactory,
        DateTimeFormat $dateTimeFormat,
        ModifiedDateTimeFactory $modifiedDateTimeFactory,
        CreatedDateTimeFactory $createdDateTimeFactory
    ) {

        $this->timeZoneFactory = $timeZoneFactory;
        $this->dateTimeFormat = $dateTimeFormat;
        $this->modifiedDateTimeFactory = $modifiedDateTimeFactory;
        $this->createdDateTimeFactory = $createdDateTimeFactory;
    }

    /**
     * Create Instance of Date Time by Post for the specified type
     *
     * @param WP_Post $post
     * @param string $type
     * @return DateTimeInterface
     * @throws InvalidArgumentException
     * @throws DateTimeException
     * @throws InvalidPostDateTimeException
     */
    public function create(WP_Post $post, string $type): DateTimeInterface
    {
        $timeZone = $this->timeZoneFactory->create();

        switch ($type) {
            case 'modified':
                $factory = $this->modifiedDateTimeFactory;
                break;
            case 'created':
            default:
                $factory = $this->createdDateTimeFactory;
                break;
        }

        return $factory->create($post, $this->dateTimeFormat, $timeZone);
    }
}
