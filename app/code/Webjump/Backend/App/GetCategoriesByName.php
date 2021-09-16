<?php

namespace Webjump\Backend\App;

use Magento\Catalog\Api\CategoryListInterface;
use Magento\Framework\Api\Search\SearchCriteriaInterfaceFactory as SearchCriteriaFactory;
use Magento\Framework\Api\Search\FilterGroupFactory;
use Magento\Framework\Api\FilterFactory;

/**
 * @method getCategoryId(string $categoryName)
 */
class GetCategoriesByName
{
    private $categoryList;

    /**
     * @var SearchCriteriaFactory
     */
    private $searchCriteriaFactory;

    /**
     * @var FilterGroupFactory
     */
    private $filterGroupFactory;

    /**
     * @var FilterFactory
     */
    private $filterFactory;

    public function __construct(
        CategoryListInterface $categoryList,
        SearchCriteriaFactory $searchCriteriaFactory,
        FilterGroupFactory $filterGroupFactory,
        FilterFactory $filterFactory
    ) {
        $this->categoryList = $categoryList;
        $this->searchCriteriaFactory = $searchCriteriaFactory;
        $this->filterGroupFactory = $filterGroupFactory;
        $this->filterFactory = $filterFactory;
    }

    /**
     * Use this method to get a category id by it's name (don't work well with duplicated names)
     * @return int
     */ 
    public function getCategoryId(string $categoryName)
    {
        $nameFilter = $this->filterFactory->create()
            ->setField(\Magento\Catalog\Model\Category::KEY_NAME)
            ->setConditionType('like')
            ->setValue($categoryName);
        
        $filterGroup = $this->filterGroupFactory->create()->setFilters([$nameFilter]);

        $searchCriteria = $this->searchCriteriaFactory->create()
            ->setFilterGroups([$filterGroup]);

        $items = $this->categoryList->getList($searchCriteria)->getItems();

        if (count($items) == 0) return false;

        foreach ($items as $helpCategory) {
            $categoryId = $helpCategory->getId();
        }
        
        return $categoryId;
    }
}
