<?php # -*- coding: utf-8 -*-

/*
 * This file is part of the WordPress Model package.
 *
 * (c) Guido Scialfa <dev@guidoscialfa.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace WordPressModel\Model;

use Brain\Monkey\Filters;
use ProjectTestsHelper\Phpunit\TestCase;
use Widoz\Bem;
use WordPressModel\Model\TaxonomySection as Testee;

/**
 * Class TaxonomySectionTest
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class TaxonomySectionTest extends TestCase
{
    public function testInstance()
    {
        $bem = $this->createMock(Bem\Service::class);
        $terms = $this->createMock(Model::class);

        $testee = new TaxonomySection($bem, $terms, '');

        self::assertInstanceOf(Testee::class, $testee);
    }

    public function testFilterDataIsAppliedCorrectly()
    {
        $bem = $this->createMock(Bem\Service::class);
        $terms = $this->createMock(Model::class);

        $bemTitleValue = $this->createMock(Bem\Valuable::class);
        $bemTermsValue = $this->createMock(Bem\Valuable::class);
        $sectionTitle = 'Section Title';
        $termsDataModel = ['terms_data_model'];

        $testee = new TaxonomySection($bem, $terms, $sectionTitle);

        $bem
            ->expects($this->exactly(2))
            ->method('forElement')
            ->withConsecutive(['title'], ['terms'])
            ->willReturnOnConsecutiveCalls(
                $bemTitleValue,
                $bemTermsValue
            );

        $terms
            ->expects($this->once())
            ->method('data')
            ->willReturn($termsDataModel);

        Filters\expectApplied(Testee::FILTER_DATA)
            ->once()
            ->with([
                'container' => [
                    'attributes' => [
                        'class' => $bem,
                    ],
                ],
                'title' => [
                    'text' => $sectionTitle,
                    'attributes' => [
                        'class' => $bemTitleValue,
                    ],
                ],
                'terms' => [
                    'items' => $termsDataModel,
                    'attributes' => [
                        'class' => $bemTermsValue,
                    ],
                ],
            ]);

        $testee->data();

        self::assertTrue(true);
    }
}
