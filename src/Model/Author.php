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

use Widoz\Bem\Service as BemService;

/**
 * Author Model
 */
final class Author implements FullFilledModel
{
    public const FILTER_DATA = 'wordpressmodel.post_author';

    /**
     * @var \WP_User
     */
    private $user;

    /**
     * @var BemService
     */
    private $bem;

    /**
     * Author constructor.
     *
     * @param BemService $bem
     * @param \WP_User $user
     */
    public function __construct(BemService $bem, \WP_User $user)
    {
        $this->bem = $bem;
        $this->user = $user;
    }

    /**
     * @return array
     */
    public function data(): array
    {
        $data = [];

        if ($this->user->exists()) {
            $authorPostsUrl = get_author_posts_url($this->user->ID);

            $data += [
                'container' => [
                    'attributes' => [
                        'class' => $this->bem,
                    ],
                ],
                'name' => [
                    'text' => $this->user->display_name,
                    'attributes' => [
                        'class' => $this->bem->forElement('name'),
                    ],
                ],
                'link' => [
                    'attributes' => [
                        'href' => $authorPostsUrl,
                        'class' => $this->bem->forElement('posts-page'),
                    ],
                ],
            ];
        }

        /**
         * Author
         *
         * @param array $data The data arguments for the template.
         */
        return apply_filters(self::FILTER_DATA, $data);
    }
}
