<?php # -*- coding: utf-8 -*-

/*
 * This file is part of the WordPress Theme Model Theme package.
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
    private const FILTER_DATA = 'wordpressmodel.archive_header';

    /**
     * @inheritdoc
     */
    public function data(): array
    {
        /**
         * Archive Template Data
         *
         * @param array $data The data arguments for the template.
         */
        return apply_filters(self::FILTER_DATA, [
            'attributes' => [
                'class' => [
                    'header' => (new ClassAttribute(new BemPrefixed('archive', 'header')))->value(),
                    'title' => (new ClassAttribute(new BemPrefixed('archive', 'title')))->value(),
                ],
            ],
            'title' => $this->title(),
            'description' => $this->description(),
            'show' => 'yes',
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
        // Set the title but if not home change it with the current archive title.
        $title = get_the_title(intval(get_option('page_for_posts')));
        if (!is_home()) {
            $title = get_the_archive_title();
        }

        return $title;
    }
}
