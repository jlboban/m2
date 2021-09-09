<?php

declare(strict_types=1);

namespace Inchoo\Sample07\ViewModel;

use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\Product\Type;
use Magento\Catalog\Model\ResourceModel\Category\Collection;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class CategoryList implements ArgumentInterface
{
    private const CATEGORY_LEVEL = 2;

    /**
     * @var Collection|null
     */
    private $loadedCategoryCollection;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * CategoryList constructor.
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @return Category[]
     */
    public function getCategories(): array
    {
        return $this->getLoadedCategoryCollection()->getItems();
    }

    /**
     * @return Collection
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function getLoadedCategoryCollection(): Collection
    {
        if ($this->loadedCategoryCollection) {
            return $this->loadedCategoryCollection;
        }

        $collection = $this->collectionFactory->create();
        $collection->addAttributeToSelect(['name', 'custom_description']);
        $collection->addAttributeToFilter('is_active', ['neq' => 0]);
        $collection->addAttributeToFilter('level', self::CATEGORY_LEVEL);
        $collection->addAttributeToSort('position');

        $this->loadedCategoryCollection = $collection->load();
        return $this->loadedCategoryCollection;
    }
}
