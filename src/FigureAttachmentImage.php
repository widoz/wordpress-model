<?php # -*- coding: utf-8 -*-

/*
 * This file is part of the wordpress-model package.
 *
 * (c) Guido Scialfa <dev@guidoscialfa.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace WordPressModel;

use Widoz\Bem\Bem;
use WordPressModel\Attribute\ClassAttribute;

/**
 * Class FigureAttachmentImage
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class FigureAttachmentImage implements Model
{
    public const FILTER_DATA = 'wordpressmodel.figure';

    /**
     * @var mixed
     */
    private $attachmentSize;

    /**
     * @var int
     */
    private $attachmentId;

    /**
     * @var Bem
     */
    private $bem;

    /**
     * FigureImage constructor
     *
     * @param int $attachmentId
     * @param mixed $attachmentSize
     * @param Bem $bem
     *
     * phpcs:disable Inpsyde.CodeQuality.ArgumentTypeDeclaration.NoArgumentType
     */
    public function __construct(int $attachmentId, $attachmentSize, Bem $bem)
    {
        // phpcs:enable

        $this->attachmentId = $attachmentId;
        $this->attachmentSize = $attachmentSize;
        $this->bem = $bem;
    }

    /**
     * @return array
     */
    public function data(): array
    {
        $figureAttributeClass = new ClassAttribute($this->bem);

        list($image, $caption) = $this->imageData();

        return apply_filters(self::FILTER_DATA, [
            'figure' => [
                'attributes' => [
                    'class' => $figureAttributeClass->value(),
                ],
            ],
            'image' => $image,
            'caption' => $caption,
        ]);
    }

    /**
     * @return array
     */
    private function imageData(): array
    {
        $attachmentImage = new AttachmentImage(
            $this->attachmentId,
            $this->attachmentSize,
            $this->bem
        );

        $imageData = $attachmentImage->data();

        return [
            $imageData['image'] ?? '',
            $imageData['caption'] ?? '',
        ];
    }
}
