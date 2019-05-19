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
use WordPressModel\Title;

/**
 * Archive Header Model
 */
final class ArchiveHeader implements FullFilledModel
{
    public const FILTER_DATA = 'wordpressmodel.archive_header';

    /**
     * @var BemService
     */
    private $bem;

    /**
     * @var Title
     */
    private $title;

    /**
     * @var Title
     */
    private $description;

    /**
     * ArchiveHeader constructor
     * @param BemService $bem
     * @param Title $title
     * @param Description $description
     */
    public function __construct(BemService $bem, Title $title, Description $description)
    {
        $this->bem = $bem;
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * @inheritdoc
     */
    public function data(): array
    {
        $title = $this->title->forArchive();
        $description = $this->description->forArchive();

        if (is_home()) {
            $title = $this->title->forHome();
            $description = $this->description->forHome();
        }

        /**
         * Archive Template Data
         *
         * @param array $data The data arguments for the template.
         */
        return apply_filters(self::FILTER_DATA, [
            'container' => [
                'attributes' => [
                    'class' => $this->bem,
                ],
            ],
            'title' => [
                'content' => $title,
                'attributes' => [
                    'class' => $this->bem->forElement('title'),
                ],
            ],
            'description' => [
                'content' => $description,
                'attributes' => [
                    'class' => $this->bem->forElement('description'),
                ],
            ],
        ]);
    }
}
