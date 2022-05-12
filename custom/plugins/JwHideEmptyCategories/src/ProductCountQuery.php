<?php

declare(strict_types=1);

namespace Jw\HideEmptyCategories;

use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\System\SalesChannel\Entity\SalesChannelRepositoryInterface;
use Shopware\Core\System\SalesChannel\SalesChannelContext;

class ProductCountQuery
{
    private SalesChannelRepositoryInterface $salesChannelProductRepository;

    public function __construct(SalesChannelRepositoryInterface $salesChannelProductRepository)
    {
        $this->salesChannelProductRepository = $salesChannelProductRepository;
    }

    public function countProducts(string $categoryId, SalesChannelContext $salesChannelContext): int
    {
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('categoriesRo.id', $categoryId));

        return $this->salesChannelProductRepository
            ->searchIds($criteria, $salesChannelContext)
            ->getTotal();
    }
}
