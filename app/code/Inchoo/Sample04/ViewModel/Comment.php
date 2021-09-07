<?php

declare(strict_types=1);

namespace Inchoo\Sample04\ViewModel;

use Inchoo\Sample04\Model\CommentFactory;
use Inchoo\Sample04\Model\ResourceModel\Comment\Collection;
use Inchoo\Sample04\Model\ResourceModel\Comment\CollectionFactory;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Block\ArgumentInterface;

/**
 * Class Comment
 * @package Inchoo\Sample04\ViewModel
 */
class Comment implements ArgumentInterface
{
    /**
     * @var CollectionFactory
     */
    protected $commentCollectionFactory;

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * News constructor.
     * @param CollectionFactory $commentCollectionFactory
     */
    public function __construct(CollectionFactory $commentCollectionFactory, Registry $registry)
    {
        $this->commentCollectionFactory = $commentCollectionFactory;
        $this->registry = $registry;
    }

    /**
     * @return mixed|null
     */
    public function getComment()
    {
        return $this->registry->registry('comment');
    }

    /**
     * @param int $newsId
     * @return Collection
     */
    public function getNewsComments(int $newsId): Collection
    {
        $commentCollection = $this->commentCollectionFactory->create();
        $commentCollection->addFilter('news_id', $newsId);

        return $commentCollection;
    }
}


