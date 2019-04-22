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

use function is_home;
use WordPressModel\Title;

/**
 * Class ArchiveTitle
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
final class ArchiveTitle implements Model
{
    public const FILTER_DATA = 'wordpressmodel.archive_title';

    /**
     * @var Title
     */
    private $title;

    /**
     * ArchiveDescription constructor
     * @param Title $title
     */
    public function __construct(Title $title)
    {
        $this->title = $title;
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
            'value' => is_home() ? $this->title->forHome() : $this->title->forArchive(),
        ]);
    }
}
