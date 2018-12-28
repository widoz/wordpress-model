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

/**
 * Class Description
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
final class ArchiveDescription implements Model
{
    public const FILTER_DATA = 'wordpressmodel.archive_description';

    /**
     * @var Title
     */
    private $description;

    /**
     * ArchiveDescription constructor
     * @param Description $description
     */
    public function __construct(Description $description)
    {
        $this->description = $description;
    }

    /**
     * @return array
     */
    public function data(): array
    {
        /**
         * Archive Template Data
         *
         * @param array $data The data arguments for the template.
         */
        return apply_filters(self::FILTER_DATA, [
            'value' => is_home() ? $this->description->forHome() : $this->description->forArchive(),
        ]);
    }
}
