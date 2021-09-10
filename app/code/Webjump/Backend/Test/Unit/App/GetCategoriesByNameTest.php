<?php
namespace Webjump\Backend\Test\Unit\App;

use Magento\Catalog\Api\CategoryListInterface;
use Magento\Catalog\Api\Data\CategoryInterface;
use Magento\Catalog\Api\Data\CategorySearchResultsInterface;
use Magento\Framework\Api\Filter;
use Magento\Framework\Api\FilterFactory;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\Search\FilterGroupFactory;
use Magento\Framework\Api\Search\SearchCriteriaInterface;
use Magento\Framework\Api\Search\SearchCriteriaInterfaceFactory;
use PHPUnit\Framework\TestCase;
use Webjump\Backend\App\GetCategoriesByName;

class GetCategoriesByNameTest extends TestCase
{
    private $categoryListMock;

    private $searchCriteriaFactoryMock;

    private $filterGroupFactoryMock;

    private $filterFactoryMock;

    private $getCategoriesByName;

    public function setUp(): void
    {
        $this->categoryListMock = $this->getMockForAbstractClass(CategoryListInterface::class);
        $this->searchCriteriaFactoryMock = $this->createMock(SearchCriteriaInterfaceFactory::class);
        $this->filterGroupFactoryMock = $this->createMock(FilterGroupFactory::class);
        $this->filterFactoryMock = $this->createMock(FilterFactory::class);
        $this->getCategoriesByName = new GetCategoriesByName(
            $this->categoryListMock,
            $this->searchCriteriaFactoryMock,
            $this->filterGroupFactoryMock,
            $this->filterFactoryMock
        );
    }

    public function testGetCategoryId()
    {
        $filterMock = $this->createMock(Filter::class);

        $this->filterFactoryMock->expects($this->once())
        ->method('create')
        ->willReturn($filterMock);

        $filterMock->expects($this->once())
        ->method('setField')
        ->with(\Magento\Catalog\Model\Category::KEY_NAME)
        ->willReturnSelf();

        $filterMock
        ->method('setConditionType')
        ->with('like')
        ->willReturnSelf();

        $filterMock
        ->method('setValue')
        ->with('Cães')
        ->willReturnSelf();

        $filterGroupMock = $this->createMock(FilterGroup::class);

        $this->filterGroupFactoryMock->expects($this->once())
        ->method('create')
        ->willReturn($filterGroupMock);

        $filterGroupMock->expects($this->once())
        ->method('setFilters')
        ->with([$filterMock])
        ->willReturnSelf();

        $searchCriteriaMock = $this->getMockForAbstractClass(SearchCriteriaInterface::class);

        $this->searchCriteriaFactoryMock->expects($this->once())
        ->method('create')
        ->willReturn($searchCriteriaMock);

        $searchCriteriaMock->expects($this->once())
        ->method('setFilterGroups')
        ->with([$filterGroupMock])
        ->willReturnSelf();

        $searchResultsMock = $this->getMockForAbstractClass(CategorySearchResultsInterface::class);

        $this->categoryListMock->expects($this->once())
        ->method('getList')
        ->with($searchCriteriaMock)
        ->willReturn($searchResultsMock);

        $categoryMock = $this->getMockForAbstractClass(CategoryInterface::class);

        $searchResultsMock->expects($this->once())
        ->method('getItems')
        ->willReturn([$categoryMock]);

        $categoryMock
        ->method('getId')
        ->willReturn(1);

        $this->assertEquals(1, $this->getCategoriesByName->getCategoryId('Cães'));
    }
}
