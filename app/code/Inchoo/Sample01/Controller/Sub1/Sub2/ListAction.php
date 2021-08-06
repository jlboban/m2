<?php

declare(strict_types=1);

namespace Inchoo\Sample01\Controller\Sub1\Sub2;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class ListAction
 * @package Inchoo\Sample01\Controller\Sub1\Sub2
 *
 * Used as an example of subfolder handling by Magento routing
 */
class ListAction implements ActionInterface
{
    /**
     * @var ResultFactory
     */
    protected $resultFactory;

    /**
     * Index constructor.
     * @param ResultFactory $resultFactory
     */
    public function __construct(ResultFactory $resultFactory)
    {
        $this->resultFactory = $resultFactory;
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Raw $resultRaw */
        $resultRaw = $this->resultFactory->create(ResultFactory::TYPE_RAW);

        return $resultRaw->setContents('Ahoy');
    }
}
