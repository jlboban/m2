<?php

declare(strict_types=1);

namespace Inchoo\Sample06\Controller\Adminhtml\Postcode;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;

class Grid extends Action implements HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'Inchoo_Sample06::view';

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Inchoo_Sample06::postcode');
        $resultPage->addBreadcrumb(__('Postcode Management'), __('Postcode Management'));
        $resultPage->getConfig()->getTitle()->prepend(__('Postcode Management'));

        return $resultPage;
    }
}
