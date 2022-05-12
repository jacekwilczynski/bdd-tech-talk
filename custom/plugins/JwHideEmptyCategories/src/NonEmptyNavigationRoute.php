<?php

declare(strict_types=1);

namespace Jw\HideEmptyCategories;

use Shopware\Core\Content\Category\CategoryEntity;
use Shopware\Core\Content\Category\SalesChannel\AbstractNavigationRoute;
use Shopware\Core\Content\Category\SalesChannel\NavigationRouteResponse;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\HttpFoundation\Request;

class NonEmptyNavigationRoute extends AbstractNavigationRoute
{
    private AbstractNavigationRoute $decorated;
    private ProductCountQuery $productCountQuery;

    public function __construct(AbstractNavigationRoute $decorated, ProductCountQuery $productCountQuery)
    {
        $this->decorated = $decorated;
        $this->productCountQuery = $productCountQuery;
    }

    public function getDecorated(): AbstractNavigationRoute
    {
        return $this->decorated;
    }

    public function load(
        string $activeId,
        string $rootId,
        Request $request,
        SalesChannelContext $context,
        Criteria $criteria
    ): NavigationRouteResponse {
        $categories = $this->decorated
            ->load($activeId, $rootId, $request, $context, $criteria)
            ->getCategories()
            ->filter(fn(CategoryEntity $category): bool => $this->hasProducts($category, $context));

        return new NavigationRouteResponse($categories);
    }

    private function hasProducts(CategoryEntity $category, SalesChannelContext $salesChannelContext): bool
    {
        $productCount = $this->productCountQuery->countProducts($category->getId(), $salesChannelContext);

        return $productCount > 0;
    }
}
