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

use Widoz\Bem\Factory;

/**
 * Archive Header Model
 */
final class ArchiveHeader implements FullFilledModel
{
    public const FILTER_DATA = 'wordpressmodel.archive_header';

    /**
     * @var Factory
     */
    private $bemFactory;

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
     * @param Title $title
     * @param Description $description
     */
    public function __construct(Factory $bemFactory, Title $title, Description $description)
    {
        $this->bemFactory = $bemFactory;
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * @inheritdoc
     */
    public function data(): array
    {
        $bem = $this->bemFactory->createService('archive-header');

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
                    'class' => $bem,
                ],
            ],
            'title' => [
                'text' => $title,
                'attributes' => [
                    'class' => $bem->forElement('title'),
                ],
            ],
            'description' => [
                'text' => $description,
                'attributes' => [
                    'class' => $bem->forElement('description'),
                ],
            ],
        ]);
    }
}
