<?php

declare(strict_types=1);

namespace Jw\HideEmptyCategories\Test\Integration;

use PHPUnit\Framework\TestCase;
use Shopware\Core\Content\Category\Service\NavigationLoader;
use Shopware\Core\Content\Product\Aggregate\ProductVisibility\ProductVisibilityDefinition;
use Shopware\Core\Defaults;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\Test\TestCaseBase\BasicTestDataBehaviour;
use Shopware\Core\Framework\Test\TestCaseBase\DatabaseTransactionBehaviour;
use Shopware\Core\Framework\Test\TestCaseBase\KernelTestBehaviour;
use Shopware\Core\Framework\Uuid\Uuid;
use Shopware\Core\System\SalesChannel\Context\SalesChannelContextFactory;
use Shopware\Core\Test\TestDefaults;

class EmptyCategoryHidingTest extends TestCase
{
    use KernelTestBehaviour;
    use DatabaseTransactionBehaviour;
    use BasicTestDataBehaviour;

    public function testOnlyCategoriesWithProductsAreVisible(): void
    {
        $context = Context::createDefaultContext();
        $productId = Uuid::randomHex();

        $productRepository = $this->getContainer()->get('product.repository');
        $productRepository->upsert(
            [
                [
                    'id'            => $productId,
                    'active'        => true,
                    'productNumber' => '123',
                    'stock'         => 10,
                    'translations'  => [Defaults::LANGUAGE_SYSTEM => ['name' => 'Cool product']],
                    'taxId'         => $this->getValidTaxId(),
                    'price'         => [
                        [
                            'currencyId' => Defaults::CURRENCY,
                            'net'        => 10,
                            'gross'      => 11.5,
                            'linked'     => false,

                        ],
                    ],
                    'visibilities'  => [
                        [
                            'salesChannelId' => TestDefaults::SALES_CHANNEL,
                            'visibility'     => ProductVisibilityDefinition::VISIBILITY_ALL,
                        ],
                    ],
                ],
            ],
            $context,
        );

        $cmsPageId = $this->getContainer()->get('cms_page.repository')->searchIds(
            (new Criteria())->addFilter(new EqualsFilter('type', 'product_list')),
            $context,
        )->firstId();

        $parentCategory = $this->getValidCategoryId();
        $notEmptyCategoryId = Uuid::randomHex();
        $emptyCategoryId = Uuid::randomHex();

        $categoryRepository = $this->getContainer()->get('category.repository');
        $categoryRepository->upsert(
            [
                [
                    'id'        => $notEmptyCategoryId,
                    'name'      => 'First category',
                    'parentId'  => $parentCategory,
                    'cmsPageId' => $cmsPageId,
                    'products'  => [['id' => $productId]],
                ],
                [
                    'id'        => $emptyCategoryId,
                    'name'      => 'Second category',
                    'parentId'  => $parentCategory,
                    'cmsPageId' => $cmsPageId,
                ],
            ],
            $context,
        );

        $salesChannelContext = $this->getContainer()->get(SalesChannelContextFactory::class)->create(
            Uuid::randomHex(),
            TestDefaults::SALES_CHANNEL,
        );

        $tree = $this->getContainer()->get(NavigationLoader::class)->load(
            $parentCategory,
            $salesChannelContext,
            $parentCategory,
        );

        $categoryIds = [];
        foreach ($tree->getTree() as $treeItem) {
            $categoryIds[] = $treeItem->getCategory()->getId();
        }

        self::assertContains($notEmptyCategoryId, $categoryIds);
        self::assertNotContains($emptyCategoryId, $categoryIds);
    }
}
