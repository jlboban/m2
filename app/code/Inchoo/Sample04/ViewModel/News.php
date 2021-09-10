<?php

declare(strict_types=1);

namespace Inchoo\Sample04\ViewModel;

use Inchoo\Sample04\Model\News as NewsModel;
use Inchoo\Sample04\Model\ResourceModel\News\Collection;
use Inchoo\Sample04\Model\ResourceModel\News\CollectionFactory;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class News implements ArgumentInterface
{
    private const LIST_LIMIT = 5;

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var CollectionFactory
     */
    protected $newsCollectionFactory;

    /**
     * News constructor.
     * @param Registry $registry
     * @param CollectionFactory $newsCollectionFactory
     */
    public function __construct(Registry $registry, CollectionFactory $newsCollectionFactory)
    {
        $this->registry = $registry;
        $this->newsCollectionFactory = $newsCollectionFactory;
    }

    /**
     * @return NewsModel|null
     */
    public function getCurrentNews(): ?NewsModel
    {
        return $this->registry->registry('current_news');
    }

    /**
     * @return Collection|NewsModel[]
     */
    public function getNewsList(): Collection
    {
        $collection = $this->newsCollectionFactory->create();
        $collection->setOrder('created_at');
        $collection->setPageSize(self::LIST_LIMIT);
        $collection->addFilter('status', 1);

        return $collection;
    }
}
