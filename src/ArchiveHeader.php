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

namespace WordPressModel;

use Widoz\Bem\BemPrefixed;
use WordPressModel\Attribute\ClassAttribute;

/**
 * Archive Header Model
 */
final class ArchiveHeader implements Model
{
    public const FILTER_DATA = 'wordpressmodel.archive_header';

    /**
     * @inheritdoc
     */
    public function data(): array
    {
        $headerClassAttribute = new ClassAttribute(new BemPrefixed('archive', 'header'));
        $titleClassAttribute = new ClassAttribute(new BemPrefixed('archive', 'title'));
        $descriptionClassAttribute = new ClassAttribute(new BemPrefixed('archive', 'description'));

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
                'text' => $this->title(),
                'attributes' => [
                    'class' => $titleClassAttribute->value(),
                ],
            ],
            'description' => [
                'text' => $this->description(),
                'attributes' => [
                    'class' => $descriptionClassAttribute->value(),
                ],
            ],
        ]);
    }

    /**
     * @return string The archive description or empty string if the page is the page for posts.
     */
    private function description(): string
    {
        return is_home() ? '' : get_the_archive_description();
    }

    /**
     * @return string The archive Title
     */
    private function title(): string
    {
        $title = get_the_archive_title();
        if (is_home()) {
            $title = get_the_title((int)get_option('page_for_posts'));
        }

        return $title;
    }
}
