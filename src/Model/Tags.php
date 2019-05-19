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
use WP_Post;

/**
 * Post Tags Model
 */
final class Tags implements FullFilledModel
{
    public const FILTER_DATA = 'wordpressmodel.tags';

    /**
     * @var WP_Post
     */
    private $post;

    /**
     * @var string
     */
    private static $taxonomy = 'post_tag';

    /**
     * Tags constructor.
     *
     * @param WP_Post $post
     */
    public function __construct(WP_Post $post)
    {
        $this->post = $post;
    }

    /**
     * @return array
     */
    public function data(): array
    {
        $bem = Factory::createServiceForStandard('post-tags');
        $terms = new Terms(self::$taxonomy, 'get_the_tags', [
            'object_ids' => [$this->post->ID],
        ]);

        return apply_filters(self::FILTER_DATA, [
            'container' => [
                'attributes' => [
                    'class' => $bem,
                ],
            ],
            'title' => [
                'content' => __('Tags: ', 'wordpress-model'),
                'attributes' => [
                    'class' => $bem->forElement('title'),
                ],
            ],
            'terms' => [
                'items' => $terms->data(),
                'attributes' => [
                    'class' => $bem->forElement('terms'),
                ],
            ],
        ]);
    }
}
