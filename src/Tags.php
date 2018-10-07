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

use WordPressModel\Attribute\ClassAttribute;
use Widoz\Bem\BemPrefixed;

/**
 * Post Tags Model
 */
final class Tags implements Model
{
    private const FILTER_DATA = 'wordpressmodel.tags';

    /**
     * @var \WP_Post
     */
    private $post;

    /**
     * @var string
     */
    private static $taxonomy = 'post_tag';

    /**
     * Tags constructor.
     *
     * @param \WP_Post $post
     */
    public function __construct(\WP_Post $post)
    {
        $this->post = $post;
    }

    /**
     * @return array
     */
    public function data(): array
    {
        $containerClass = new ClassAttribute(new BemPrefixed('post-tags'));
        $titleClass = new ClassAttribute(new BemPrefixed('post-tags', 'title'));
        $tagsClass = new ClassAttribute(new BemPrefixed('terms'));
        $terms = new Terms(self::$taxonomy, 'get_the_tags', [
            'object_ids' => [$this->post->ID],
        ]);

        return apply_filters(self::FILTER_DATA, [
            'attributes' => [
                'class' => $containerClass->value(),
            ],
            'title' => [
                'label' => __('Tags: ', 'wordpress-model'),
                'attributes' => [
                    'class' => $titleClass->value(),
                ],
            ],
            'terms' => [
                'items' => $terms->data(),
                'attributes' => [
                    'class' => $tagsClass->value(),
                ],
            ],
        ]);
    }
}
