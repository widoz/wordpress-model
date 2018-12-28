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

use Widoz\Bem\BemPrefixed;
use WordPressModel\Attribute\ClassAttribute;

/**
 * Archive Header Model
 */
final class ArchiveHeader implements Model
{
    public const FILTER_DATA = 'wordpressmodel.archive_header';

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
    public function __construct(Title $title, Description $description)
    {
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * @inheritdoc
     */
    public function data(): array
    {
        $headerClassAttribute = new ClassAttribute(new BemPrefixed('archive', 'header'));
        $titleClassAttribute = new ClassAttribute(new BemPrefixed('archive', 'title'));
        $descriptionClassAttribute = new ClassAttribute(new BemPrefixed('archive', 'description'));

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
                    'class' => $headerClassAttribute->value(),
                ],
            ],
            'title' => [
                'text' => $title,
                'attributes' => [
                    'class' => $titleClassAttribute->value(),
                ],
            ],
            'description' => [
                'text' => $description,
                'attributes' => [
                    'class' => $descriptionClassAttribute->value(),
                ],
            ],
        ]);
    }
}
