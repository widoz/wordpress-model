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

use function get_the_title;
use Widoz\Bem\Service as ServiceBem;
use WP_Post;
use WP_Query;

/**
 * Post Title Model
 */
class PostTitle implements PartialModel
{
    public const FILTER_DATA = 'wordpressmodel.post_title';

    /**
     * @var ServiceBem
     */
    private $bem;

    /**
     * @var WP_Post
     */
    private $post;

    /**
     * PostTitle constructor.
     *
     * @param ServiceBem $bem
     * @param WP_Post $post
     */
    public function __construct(ServiceBem $bem, WP_Post $post)
    {
        $this->bem = $bem;
        $this->post = $post;
    }

    /**
     * @inheritDoc
     */
    public function data(): array
    {
        /**
         * Post Title
         *
         * @param array $data The data to inject into the template.
         */
        return apply_filters(self::FILTER_DATA, [
            'title' => [
                'content' => get_the_title($this->post),
                'attributes' => [
                    'class' => $this->bem->forElement('title'),
                ],
            ],
        ]);
    }
}
