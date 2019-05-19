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

use function is_home;
use Widoz\Bem\Service as BemService;
use WordPressModel\Description;

/**
 * Class Description
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
final class ArchiveDescription implements PartialModel
{
    public const FILTER_DATA = 'wordpressmodel.archive_description';

    /**
     * @var Description
     */
    private $description;

    /**
     * @var BemService
     */
    private $bem;

    /**
     * ArchiveDescription constructor
     * @param BemService $bem
     * @param Description $description
     */
    public function __construct(BemService $bem, Description $description)
    {
        $this->bem = $bem;
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
            'description' => [
                'content' => is_home() ? $this->description->forHome() : $this->description->forArchive(),
                'attributes' => [
                    'class' => $this->bem->forElement('description'),
                ],
            ],
        ]);
    }
}
