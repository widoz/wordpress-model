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

use DomainException;
use Widoz\Bem\Service as ServiceBem;

/**
 * Comment Section Title Model
 */
final class CommentSectionTitle implements PartialModel
{
    public const FILTER_DATA = 'wordpressmodel.comments_section_title';

    /**
     * @var ServiceBem
     */
    private $bem;

    /**
     * @var string
     */
    private $title;

    /**
     * CommentSectionTitle constructor
     * @param ServiceBem $bem
     * @param string $title
     */
    public function __construct(ServiceBem $bem, string $title)
    {
        $this->bem = $bem;
        $this->title = $title;
    }

    /**
     * @return array
     */
    public function data(): array
    {
        /**
         * Comment Section Title
         *
         * @param array $data The data arguments for the template.
         */
        return apply_filters(self::FILTER_DATA, [
            'content' => $this->title,
            'attributes' => [
                'class' => $this->bem->forElement('title'),
            ],
        ]);
    }
}
